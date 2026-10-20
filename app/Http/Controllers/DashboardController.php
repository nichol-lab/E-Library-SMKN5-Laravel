<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Loan;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = User::find(session('user_id'));

        if (!$user) {
            return redirect()->route('login');
        }

        $data = [
            'user' => $user,

            'totalBooks' => Book::count(),

            'totalCategories' => Category::count(),

            'totalUsers' => User::count(),

            'totalLoans' => Loan::count(),

            'pendingLoans' => Loan::where('status', 'pending')->count(),

            'approvedLoans' => Loan::where('status', 'approved')->count(),

            'borrowedLoans' => Loan::where('status', 'borrowed')->count(),

            'returnedLoans' => Loan::where('status', 'returned')->count(),
        ];

        return view('dashboard', $data);
    }
}