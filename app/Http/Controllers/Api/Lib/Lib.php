<?php

namespace App\Http\Controllers\Api\Lib;

use Illuminate\Http\Request;

trait Lib
{
    public function filterFollow($query, Request $request)
    {
        return
            $query->when(isset($request->approved), function ($query) use ($request) {
                (bool)$request->approved ? $query->whereNotNull('approved_at') : $query->whereNull('approved_at');
            })
                ->when($request->approved_from, function ($query, $approved_from) {
                    $query->where('approved_at', '>=', $approved_from);
                })
                ->when($request->approved_to, function ($query, $approved_to) {
                    $query->where('approved_at', '<=', $approved_to);
                })
                ->when($request->create_from, function ($query, $create_from) {
                    $query->where('created_at', '>=', $create_from);
                })
                ->when($request->create_to, function ($query, $create_to) {
                    $query->where('created_at', '<=', $create_to);
                })
                ->when($request->update_from, function ($query, $update_from) {
                    $query->where('updated_at', '>=', $update_from);
                })
                ->when($request->update_to, function ($query, $update_to) {
                    $query->where('updated_at', '<=', $update_to);
                });
    }
}
