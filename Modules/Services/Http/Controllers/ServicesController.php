<?php

namespace Modules\Services\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Modules\Services\Entities\Service;
use Modules\Services\Http\Requests\ServiceRequest;
use Modules\Services\Repositories\ServiceRepository;

class ServicesController extends Controller
{
    private $repository;
    private $subServiceRepository;

    public function __construct(ServiceRepository $repository)
    {
        $this->middleware('permission:read_services')->only(['index']);
        $this->middleware('permission:create_services')->only(['create', 'store']);
        $this->middleware('permission:update_services')->only(['edit', 'update']);
        $this->middleware('permission:delete_services')->only(['destroy']);
        $this->middleware('permission:show_services')->only(['show']);
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $services = $this->repository->all();
        return view('services::services.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('services::services.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ServiceRequest $request
     */
    public function store(ServiceRequest $request)
    {
        $data = $request->except('_token', '_method');

        $service = $this->repository->create($data);

        flash(trans('services::services.messages.created'))->success();

        return redirect()->route('dashboard.services.show', $service);
    }


    /**
     * Display the specified resource.
     *
     * @param Service $service
     * @return View
     */
    public function show(Service $service)
    {
        $service = $this->repository->find($service);

        return view('services::services.show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Service $service
     * @return View
     */
    public function edit(Service $service)
    {
        $service = $this->repository->find($service);

        return view('services::services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ServiceRequest $request
     * @param Service $service
     */
    public function update(ServiceRequest $request, Service $service)
    {
        $data = $request->except('_token', '_method');

        $service = $this->repository->update($service, $data);

        flash(trans('services::services.messages.updated'))->success();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Service $service
     */
    public function destroy(Service $service)
    {
        $exists = $this->canDelete($service);

        if (!$exists) {
            $this->repository->delete($service);
        }

        flash(trans('services::services.messages.' . ($exists ? "cant-delete" : "deleted")))->error();

        return redirect()->route('dashboard.services.index');
    }

    public function canDelete($service)
    {
        return false;
    }



    public function getOrder()
    {
        $services = $this->repository->order();
        return view('services::services.order', get_defined_vars());
    }


    public function order(Request $request)
    {
        foreach ($request->services as $key => $service) {
            $rank = $key + 1;
            Service::where('id', $service)->update([
                'rank' => $rank,
            ]);
        }

        flash(trans('services::services.messages.ordered'))->success();

        return redirect()->route('dashboard.order.form.services');
    }
}
