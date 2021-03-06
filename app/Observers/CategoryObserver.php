<?php

namespace App\Observers;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CategoryObserver
{
    /**
     * Handle the Category "created" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function created(Category $category)
    {
        // $user = Auth::user(); для обычной работы
        $user = Auth::loginUsingId(1); // чтоб авторизоваться в коммандной  строке
        $now = Carbon::now()->toDateTimeString();
        Log::info("{$now}: {$user->name}, CREATE_CATEGORY {$category->name}");
    }

    /**
     * Handle the Category "updated" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function updated(Category $category)
    {
        $changedField = [];
        $user = Auth::user();
        $changedField = $category->getDirty();
        foreach ($changedField as $key => $value) {
        Log::info("{$user->name}: UPDATE_CATEGORY старое значение поля {$key} было: {$category->getOriginal($key)}, а теперь: {$value}"); 
        }
    }

    /**
     * Handle the Category "deleted" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function deleted(Category $category)
    {
        $user = Auth::user();
        Log::info("{$user->name}, DELETE_CATEGORY {$category->name}");
    }

    /**
     * Handle the Category "restored" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function restored(Category $category)
    {
        //
    }

    /**
     * Handle the Category "force deleted" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function forceDeleted(Category $category)
    {
        //
    }
}