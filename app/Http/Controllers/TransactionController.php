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
     * @OA\Get(
     *     path="/transactions",
     *     summary="Display a listing of transactions",
     *     @OA\Response(
     *         response=200,
     *         description="List of transactions",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Transaction")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $transactions = Transaction::all();
        return response()->json($transactions);
    }

    /**
     * @OA\Post(
     *     path="/transactions",
     *     summary="Store a newly created transaction",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(property="name", type="string", example="Salary"),
     *                 @OA\Property(property="date", type="string", format="date", example="2024-09-01"),
     *                 @OA\Property(property="deposit", type="number", format="float", example=1000.00),
     *                 @OA\Property(property="expense", type="number", format="float", example=0.00)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Transaction created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Transaction")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object", additionalProperties=true)
     *         )
     *     )
     * )
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
     * @OA\Get(
     *     path="/transactions/{id}",
     *     summary="Display the specified transaction",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Transaction found",
     *         @OA\JsonContent(ref="#/components/schemas/Transaction")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Transaction not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Transaction not found")
     *         )
     *     )
     * )
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
     * @OA\Put(
     *     path="/transactions/{id}",
     *     summary="Update the specified transaction",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(property="name", type="string", example="Updated Salary"),
     *                 @OA\Property(property="date", type="string", format="date", example="2024-09-15"),
     *                 @OA\Property(property="deposit", type="number", format="float", example=1200.00),
     *                 @OA\Property(property="expense", type="number", format="float", example=0.00)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Transaction updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Transaction")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Transaction not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Transaction not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object", additionalProperties=true)
     *         )
     *     )
     * )
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
     * @OA\Delete(
     *     path="/transactions/{id}",
     *     summary="Remove the specified transaction",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Transaction deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Transaction deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Transaction not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Transaction not found")
     *         )
     *     )
     * )
     */
    public function destroy(String $id)
    {
        $transaction = Transaction::find($id);

        if ($transaction) {
            $transaction->delete();
            return response()->json([
                'status' => true,
                'message' => 'Transaction deleted successfully',
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'Transaction not found',
        ], 404);
    }
}
