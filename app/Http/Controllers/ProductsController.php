<?php namespace CodeCommerce\Http\Controllers;

use CodeCommerce\Product;
use CodeCommerce\Category;
use CodeCommerce\Http\Requests;
use CodeCommerce\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ProductsController extends Controller {

	private $productModel;

	public function __construct(product $productModel)
	{
		$this->productModel = $productModel;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$products = $this->productModel->paginate(10);

		return view('products.index', compact('products'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Category $category)
	{
		$categories = $category->lists('name','id');

		return view('products.create', compact('categories'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Requests\ProductRequest $request)
	{
		$input = $request->all();

		$product = $this->productModel->fill($input);

		$product->save();

		return redirect()->route('products');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, Category $category)
	{

		$categories = $category->lists('name','id');
		$product = $this->productModel->find($id);

		return view('products.edit', compact('product','categories'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Requests\ProductRequest $request, $id)
	{
		$this->productModel->find($id)->update($request->all());

		return redirect()->route('products');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$this->productModel->find($id)->delete();

		return redirect()->route('products');
	}

}
