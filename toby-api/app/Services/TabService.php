<?php

namespace App\Services;

use App\Repositories\TabRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TabService
{
    protected $tabRepository;

    public function __construct(TabRepository $tabRepository)
    {
        $this->tabRepository = $tabRepository;
    }

    public function getAllTabs($id = null)
    {
        return $this->tabRepository->all();
    }

    public function getAllTabsWithCollection($id = null)
    {
        return $this->tabRepository->all(['collection']);
    }

    public function getTabById($id)
    {
        return $this->tabRepository->find($id);
    }

    public function getTabByIdWithCollection($id)
    {
        return $this->tabRepository->find($id, ['collection']);
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

        $data['user_id'] = Auth::id();
        $this->tabRepository->create($data);
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

        $this->tabRepository->update($id, $data);
        return response()->json([
            'success' => true,
            'message' => 'Tab updated successfully',
            'errors' => [],
        ], Response::HTTP_OK);
    }

    public function deleteTab($id)
    {
        return $this->tabRepository->delete($id);
    }
}
