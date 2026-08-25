<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class ProductController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $query = $user->role === 'admin'
        ? Product::query()
        : Product::where('user_id', '!=', $user->id);

        if (request()->filled('filter.category')) {
            $query->where('category', request('filter.category'));
        }

        $products = $query->paginate(6)->withQueryString();

        return view('inicio', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('images', 'public');
        }

        $data['user_id'] = auth()->id();

        Product::query()->create($data);

        return to_route('products.manage')->with('message', 'Alterado com sucesso!');
    }
    
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();

            if ($request->hasFile('photo')) {
                $data['photo'] = $request->file('photo')->store('images', 'public');
            }

        $product->update($data);

        return to_route('products.manage')->with('message', 'Alterado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return to_route('products.manage')->with('message', 'Deletado com sucesso!');
    }

    public function search(Request $request)
    {
        $filters = $request->except('_token');

        $products = Product::where('name', 'LIKE', "%{$request->search}%")
            ->orWhere('category', 'LIKE', "%{$request->search}%")
            ->paginate(6);

        return view('inicio', compact('products', 'filters'));
    }
    
    public function manage()
    {
        $isAdmin = auth()->user()->role === 'admin';

        $products = $isAdmin
            ? Product::paginate(5)
            : Product::where('user_id', auth()->id())->paginate(5);

        //grafico de rodutos cadastrados por mes
        $chart_options = [
            'chart_title' => 'Quantidade de Produtos Cadastrados por Mês',
            'model'       => Product::class,
            'chart_type'  => 'bar',
            'report_type' => 'group_by_date',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'chart_color' => '82,186,86',
            'date_format' => 'm/Y',
        ];
 
        $chart = new LaravelChart($chart_options);
 
        return view('products.manage-products', compact('products', 'chart'));
    }

    public function detail($id)
    {
        $product = Product::findOrFail($id);
        
        return view('products.product-details', compact('product'));
    }
}
