<?php

namespace App\Services;

use App\Repositories\TabRepository;
use App\Repositories\CachedTabRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class TabService
{
    protected $tabRepository;
    protected $cacheTabRepository;

    public function __construct(TabRepository $tabRepository, CachedTabRepository $cacheTabRepository)
    {
        $this->tabRepository = $tabRepository;
        $this->cacheTabRepository = $cacheTabRepository;
    }

    public function getAllTabs()
    {
        return $this->cacheTabRepository->all();
    }

    public function getTabById($id)
    {
        $result = null;
        try {
            $result = $this->tabRepository->find($id);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error getting tab',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $result;
    }


    public function createTab($data)
    {
        $validator = Validator::make($data, [
            'title' => 'required|string|max:255',
            'url' => 'required|url',
            'collection_id' => 'required|exists:collections,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input',
                'errors' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }

        $data['user_id'] =
            Auth::guard('api')->user()->id ? Auth::guard('api')->user()->id : Auth::id();

        try {
            $this->tabRepository->create($data);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating tab',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'success' => true,
            'message' => 'Tab created successfully',
            'errors' => [],
        ], Response::HTTP_CREATED);
    }

    public function updateTab($id, $data)
    {
        $validator = Validator::make($data, [
            'title' => 'sometimes|string|max:255',
            'url' => 'sometimes|url',
            'collection_id' => 'sometimes|exists:collections,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input',
                'errors' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }

        try {
            $this->tabRepository->update($id, $data);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating tab',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        Cache::forget('tabs.all');
        Cache::forget('tabs.find.' . $id);
        return response()->json([
            'success' => true,
            'message' => 'Tab updated successfully',
            'errors' => [],
        ], Response::HTTP_OK);
    }

    public function deleteTab($id)
    {
        $result = null;
        try {
            $result = $this->tabRepository->delete($id);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting tag',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        Cache::forget('tabs.all');
        return $result;
    }
}
