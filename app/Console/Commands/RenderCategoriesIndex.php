<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\User;

class RenderCategoriesIndex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'render:categories-index {--per_page=20}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Render admin categories index view to storage for inspection';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $perPage = (int) $this->option('per_page') ?: 20;
        $allowed = [10, 20, 50, 100];
        if (! in_array($perPage, $allowed)) {
            $perPage = 20;
        }


        // Authenticate a user for rendering the admin layout if possible
        if (! Auth::check()) {
            $firstUser = User::first();
            if ($firstUser) {
                Auth::login($firstUser);
            }
        }

        $categories = Category::withCount('products')->paginate($perPage);
        $total = Category::count();
        $activeCount = Category::where('is_active', true)->count();

        $html = view('admin.categories.index', compact('categories', 'total', 'activeCount'))->render();

        $path = storage_path('app/debug_categories_index.html');
        file_put_contents($path, $html);

        $this->info('Rendered categories index to: ' . $path);
        return 0;
    }
}
