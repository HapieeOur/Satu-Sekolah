<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Services\RoomServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRoomRequest;
use App\Http\Requests\Admin\UpdateRoomRequest;
use App\Models\Room;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoomController extends Controller
{
    public function __construct(
        protected RoomServiceInterface $roomService
    ) {}

    public function index(Request $request): View
    {
        $search = $request->input('search');
        $rooms = $this->roomService->getPaginated(15, $search)->withQueryString();

        return view('admin.rooms.index', compact('rooms'));
    }

    public function create(): View
    {
        return view('admin.rooms.create');
    }

    public function store(StoreRoomRequest $request): RedirectResponse
    {
        $this->roomService->create($request->validated());

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Data ruangan berhasil ditambahkan.');
    }

    public function edit(Room $room): View
    {
        return view('admin.rooms.edit', compact('room'));
    }

    public function update(UpdateRoomRequest $request, Room $room): RedirectResponse
    {
        $this->roomService->update($room, $request->validated());

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Data ruangan berhasil diperbarui.');
    }

    public function destroy(Room $room): RedirectResponse
    {
        $this->roomService->delete($room);

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Data ruangan berhasil dihapus.');
    }
}
