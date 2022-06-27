<?php

namespace Mohan9a\AdminlteFaq\Http\Controllers;

use Illuminate\Http\Request;
use Mohan9a\AdminlteFaq\Models\Faq;

class FAQController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faqs = Faq::orderBy('order','ASC')->get();
        return view('adminltefaq::faqs.index',compact('faqs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adminltefaq::faqs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'status' => 'required',
        ]);
        $data = $request->all();
        $faqs = new Faq;
        $data['order'] = $faqs->highestOrderItem();

        Faq::create($data);

        return redirect()->route('faqs.index')
            ->with('success', 'Faq created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Faq $faq)
    {
        return view('adminltefaq::faqs.edit', compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'status' => 'required'
        ]);
        $faq->update($request->all());

        return redirect()->route('faqs.index')
            ->with('success', 'FAQ updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $isDeleted = Faq::where('id',$id)->delete();
        if($isDeleted){
            return response()->json([
                'success' => true,
                'message' => 'FAQ deleted successfully!',
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'FAQ failed to deleted!',
        ]);
    }
    
    public function order_item(Request $request) {
        $faqOrder = json_decode($request->input('order'));
        $this->orderMenu($faqOrder, null);
    }

    private function orderMenu(array $faqItems) {
        foreach ($faqItems as $index => $faqItem) {
            $faq = Faq::findOrFail($faqItem->id);
            $faq->order = $index + 1;
            $faq->save();
        }
    }
}
