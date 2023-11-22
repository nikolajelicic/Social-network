<?php 

namespace App\Interfaces;

use Illuminate\Http\Request;

interface PageInterface{

    public function profilePage();

    public function showEditPostPage(Request $request, $id);

    public function showAddFriendsPage();
}