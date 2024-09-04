<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Transaction::all();
        return response()->json($transactions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'deposit' => 'nullable|numeric|min:0',
            'expense' => 'nullable|numeric|min:0',
        ]);

        $transaction = auth()->user()->transactions()->create($validatedData);

        return response()->json($transaction, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        return response()->json($transaction);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, String $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'deposit' => 'nullable|numeric|min:0',
            'expense' => 'nullable|numeric|min:0',
        ]);
    
        $transaction = Transaction::find($id);
        $transaction->update($request->all());
            return response()->json([
                'transaction' => $transaction
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(String $id)
    {
        $transaction = Transaction::find($id);

        if ($transaction) {
            $transaction->delete();
            return response()->json([
                'status' => true,
                'message' => 'User deleted successfully',
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'User not found',
        ], 404);
    }
}
