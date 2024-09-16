<?php

namespace App\Services;

use App\Repositories\TabRepository;
use App\Repositories\CachedTabRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
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


        try {
            $this->tabRepository->update($id, $data);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating tab',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }


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

        return $result;
    }
}
