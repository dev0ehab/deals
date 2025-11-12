<?php

namespace Modules\Products\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Products\Entities\Product;
use Modules\Products\Entities\ProductFeature;
use Modules\Products\Http\Requests\ProductFeatureRequest;

class ProductFeatureController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * ProductFeatureController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:read_products')->only(['show']);
        $this->middleware('permission:create_products')->only(['store']);
        $this->middleware('permission:update_products')->only(['edit', 'update']);
        $this->middleware('permission:delete_products')->only(['destroy']);
    }

    /**
     * Store a newly created product feature.
     *
     * @param ProductFeatureRequest $request
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProductFeatureRequest $request, Product $product)
    {
        try {
            $validated = $request->validated();

            $feature = ProductFeature::create([
                'product_id'    => $product->id,
                'text_ar'       => $validated['text_ar'] ?? null,
                'text_en'       => $validated['text_en'] ?? null,
                'feature_id'    => $validated['feature_id'] ?? null,
                'feature_type'  => $validated['feature_type'],
                'text_value_ar' => $validated['text_value_ar'] ?? null,
                'text_value_en' => $validated['text_value_en'] ?? null,
                'is_active'     => $request->has('is_active') ? 1 : 0,
            ]);

            // Handle image upload for image type features
            if ($validated['feature_type'] === 'image' && $request->hasFile('image')) {
                $feature->addMediaFromRequest('image')->toMediaCollection('images');
            }

            // Handle feature options (for data type features)
            if ($validated['feature_type'] === 'data' && isset($validated['feature_options']) && !empty($validated['feature_options'])) {
                $feature->featureOptions()->sync($validated['feature_options']);
            }

            flash(trans('products::products.features.created', [], app()->getLocale()))->success();

            return redirect()->route('dashboard.products.show', $product);
        } catch (\Exception $e) {
            flash(trans('products::products.messages.error', [], app()->getLocale()) ?: 'An error occurred while creating the product feature.')->error();
            return redirect()->back()->withInput();
        }
    }

    /**
     * Show the form for editing the specified product feature.
     *
     * @param Product $product
     * @param ProductFeature $feature
     * @return \Illuminate\View\View
     */
    public function edit(Product $product, ProductFeature $feature)
    {
        // Ensure the feature belongs to the product
        if ($feature->product_id !== $product->id) {
            abort(404);
        }

        $feature->load(['feature', 'featureOptions']);

        return view('products::features.edit', compact('product', 'feature'));
    }

    /**
     * Update the specified product feature in storage.
     *
     * @param ProductFeatureRequest $request
     * @param Product $product
     * @param ProductFeature $feature
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProductFeatureRequest $request, Product $product, ProductFeature $feature)
    {
        // Ensure the feature belongs to the product
        if ($feature->product_id !== $product->id) {
            abort(404);
        }

        try {
            $validated = $request->validated();

            $feature->update([
                'text_ar'       => $validated['text_ar'] ?? null,
                'text_en'       => $validated['text_en'] ?? null,
                'feature_id'    => $validated['feature_id'] ?? null,
                'feature_type'  => $validated['feature_type'],
                'text_value_ar' => $validated['text_value_ar'] ?? null,
                'text_value_en' => $validated['text_value_en'] ?? null,
                'is_active'     => $request->has('is_active') ? 1 : 0,
            ]);

            // Handle image upload for image type features
            if ($validated['feature_type'] === 'image' && $request->hasFile('image')) {
                // Remove old image if exists
                $feature->clearMediaCollection('images');
                $feature->addMediaFromRequest('image')->toMediaCollection('images');
            } elseif ($validated['feature_type'] !== 'image') {
                // Clear image collection if feature type is not image
                $feature->clearMediaCollection('images');
            }

            // Handle feature options (for data type features)
            if ($validated['feature_type'] === 'data' && isset($validated['feature_options']) && !empty($validated['feature_options'])) {
                $feature->featureOptions()->sync($validated['feature_options']);
            } else {
                // Clear options if feature type is not data
                $feature->featureOptions()->sync([]);
            }

            flash(trans('products::products.features.updated', [], app()->getLocale()) ?: 'Product feature has been updated successfully.')->success();

            return redirect()->route('dashboard.products.show', $product);
        } catch (\Exception $e) {
            flash(trans('products::products.messages.error', [], app()->getLocale()) ?: 'An error occurred while updating the product feature.')->error();
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified product feature from storage.
     *
     * @param Product $product
     * @param ProductFeature $feature
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Product $product, ProductFeature $feature)
    {
        // Ensure the feature belongs to the product
        if ($feature->product_id !== $product->id) {
            abort(404);
        }

        try {
            // Clear media collection
            $feature->clearMediaCollection('images');

            // Detach feature options
            $feature->featureOptions()->detach();

            // Delete the feature
            $feature->delete();

            flash(trans('products::products.features.deleted', [], app()->getLocale()) ?: 'Product feature has been deleted successfully.')->success();

            return redirect()->route('dashboard.products.show', $product);
        } catch (\Exception $e) {
            flash(trans('products::products.messages.error', [], app()->getLocale()) ?: 'An error occurred while deleting the product feature.')->error();
            return redirect()->back();
        }
    }
}

