<?php

namespace Modules\FAQs\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Modules\FAQs\Entities\FAQ;
use Modules\FAQs\Http\Requests\FAQRequest;
use Modules\FAQs\Repositories\FAQRepository;

class FAQsController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * @var FAQRepository
     */
    private $repository;

    /**
     * CountryController constructor.
     *
     * @param FAQRepository $repository
     *
     */
    public function __construct(FAQRepository $repository)
    {
        $this->middleware('permission:read_f_a_qs')->only(['index']);
        $this->middleware('permission:create_f_a_qs')->only(['create', 'store']);
        $this->middleware('permission:update_f_a_qs')->only(['edit', 'update']);
        $this->middleware('permission:delete_f_a_qs')->only(['destroy']);
        $this->middleware('permission:show_f_a_qs')->only(['show']);

        $this->repository = $repository;
    }

    public function index()
    {
        $f_a_qs = $this->repository->all();

        return view('f_a_qs::f_a_qs.index', compact('f_a_qs'));
    }


    public function create()
    {
        return view('f_a_qs::f_a_qs.create');
    }


    public function store(FAQRequest $request)
    {
        $f_a_q = $this->repository->create($request->all());

        flash(trans('f_a_qs::f_a_qs.messages.created'))->success();

        return redirect()->route('dashboard.f_a_qs.show', $f_a_q);
    }


    public function show(FAQ $f_a_q)
    {
        $f_a_q = $this->repository->find($f_a_q);

        return view('f_a_qs::f_a_qs.show', compact('f_a_q'));
    }

    public function edit(FAQ $f_a_q)
    {
        return view('f_a_qs::f_a_qs.edit', compact('f_a_q'));
    }


    public function update(FAQRequest $request, FAQ $f_a_q)
    {
        $f_a_q = $this->repository->update($f_a_q, $request->all());

        flash(trans('f_a_qs::f_a_qs.messages.updated'))->success();

        return redirect()->route('dashboard.f_a_qs.show', $f_a_q);
    }


    public function destroy(FAQ $f_a_q)
    {
        $this->repository->delete($f_a_q);

        flash(trans('f_a_qs::f_a_qs.messages.deleted'))->error();

        return redirect()->route('dashboard.f_a_qs.index');
    }
}
