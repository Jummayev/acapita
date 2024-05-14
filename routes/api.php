<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function () {
    Route::get('/', function (Request $request) {
        return okResponse(['message' => 'Welcome to the API!']);
    });

    /**--------------------------------------------------------------------------------
     * Auth ROUTES  => START
     * --------------------------------------------------------------------------------*/
    Route::prefix('admin/auth')->group(function () {
        Route::post('login', [\App\Http\Controllers\Api\v1\AuthController::class, 'login']);
        Route::middleware(['auth:api', 'scope:' . User::ROLE_ADMIN])->group(function () {
            Route::get('get-me', [\App\Http\Controllers\Api\v1\AuthController::class, 'getMe']);
            Route::get('logout', [\App\Http\Controllers\Api\v1\AuthController::class, 'logout']);
        });
    });
    /**--------------------------------------------------------------------------------
     * Auth ROUTES  => END
     * --------------------------------------------------------------------------------*/

    Route::prefix('admin/users')->middleware(['auth:api', 'scope:' . User::ROLE_ADMIN])->group(function () {
        Route::put('/update-me', [\App\Http\Controllers\Api\v1\AuthController::class, 'updateMe']);
    });

    /**--------------------------------------------------------------------------------
     * Pages ROUTES  => START
     * --------------------------------------------------------------------------------*/
    Route::prefix('admin/pages')->group(function () {
        Route::middleware(['auth:api', 'scope:' . User::ROLE_ADMIN])->group(function () {
            Route::get('/', [\App\Http\Controllers\Api\v1\PageController::class, 'adminIndex']);
            Route::post('/', [\App\Http\Controllers\Api\v1\PageController::class, 'store'])->middleware('scope:' . User::ROLE_ADMIN);
            Route::post('/sort', [\App\Http\Controllers\Api\v1\PageController::class, 'sort'])->middleware('scope:' . User::ROLE_ADMIN);
            Route::get('{id}', [\App\Http\Controllers\Api\v1\PageController::class, 'show'])->whereNumber('id');
            Route::put('{page}', [\App\Http\Controllers\Api\v1\PageController::class, 'update'])->whereNumber('page')->middleware('scope:' . User::ROLE_ADMIN);
            Route::delete('{page}', [\App\Http\Controllers\Api\v1\PageController::class, 'destroy'])->whereNumber('page')->middleware('scope:' . User::ROLE_ADMIN);
        });
    });
    Route::prefix('pages')->group(function () {
        Route::get('/', [\App\Http\Controllers\Api\v1\PageController::class, 'index']);
        Route::get('{slug}', [\App\Http\Controllers\Api\v1\PageController::class, 'frontShow']);
    });
    /**--------------------------------------------------------------------------------
     * Pages ROUTES  => END
     * --------------------------------------------------------------------------------*/

    /**--------------------------------------------------------------------------------
     * Settings ROUTES  => START
     * --------------------------------------------------------------------------------*/
    Route::prefix('admin/settings')->group(function () {
        Route::middleware(['auth:api', 'scope:' . User::ROLE_ADMIN])->group(function () {
            Route::get('/', [\App\Http\Controllers\Api\v1\SettingController::class, 'adminIndex']);
            Route::post('/', [\App\Http\Controllers\Api\v1\SettingController::class, 'store'])->middleware('scope:' . User::ROLE_ADMIN);
            Route::post('/sort', [\App\Http\Controllers\Api\v1\SettingController::class, 'sort'])->middleware('scope:' . User::ROLE_ADMIN);
            Route::get('{id}', [\App\Http\Controllers\Api\v1\SettingController::class, 'show'])->whereNumber('id');
            Route::put('{setting}', [\App\Http\Controllers\Api\v1\SettingController::class, 'update'])->whereNumber('setting')->middleware('scope:' . User::ROLE_ADMIN);
            Route::delete('{setting}', [\App\Http\Controllers\Api\v1\SettingController::class, 'destroy'])->whereNumber('setting')->middleware('scope:' . User::ROLE_ADMIN);
        });
    });
    Route::prefix('settings')->group(function () {
        Route::get('/', [\App\Http\Controllers\Api\v1\SettingController::class, 'index']);
        Route::get('{slug}', [\App\Http\Controllers\Api\v1\SettingController::class, 'slug'])->where('slug', '.*');
    });

    /**--------------------------------------------------------------------------------
     * Settings ROUTES  => END
     * --------------------------------------------------------------------------------*/

    /**--------------------------------------------------------------------------------
     * posts ROUTES  => START
     * --------------------------------------------------------------------------------*/
    Route::prefix('admin/posts')->group(function () {
        Route::middleware(['auth:api', 'scope:' . User::ROLE_ADMIN])->group(function () {
            Route::get('/', [\App\Http\Controllers\Api\v1\PostController::class, 'adminIndex']);
            Route::post('/', [\App\Http\Controllers\Api\v1\PostController::class, 'store'])->middleware('scope:' . User::ROLE_ADMIN);
            Route::post('/sort', [\App\Http\Controllers\Api\v1\PostController::class, 'sort'])->middleware('scope:' . User::ROLE_ADMIN);
            Route::get('{id}', [\App\Http\Controllers\Api\v1\PostController::class, 'show'])->whereNumber('id');
            Route::put('{post}', [\App\Http\Controllers\Api\v1\PostController::class, 'update'])->whereNumber('post')->middleware('scope:' . User::ROLE_ADMIN);
            Route::delete('{post}', [\App\Http\Controllers\Api\v1\PostController::class, 'destroy'])->whereNumber('post')->middleware('scope:' . User::ROLE_ADMIN);
        });
    });
    Route::prefix('posts')->group(function () {
        Route::get('/', [\App\Http\Controllers\Api\v1\PostController::class, 'index']);
        Route::get('{slug}', [\App\Http\Controllers\Api\v1\PostController::class, 'frontShow']);
    });
    /**--------------------------------------------------------------------------------
     * posts ROUTES  => END
     * --------------------------------------------------------------------------------*/

    /**--------------------------------------------------------------------------------
     * menus ROUTES  => START
     * --------------------------------------------------------------------------------*/
    Route::prefix('admin/menus')->group(function () {
        Route::middleware(['auth:api', 'scope:' . User::ROLE_ADMIN])->group(function () {
            Route::get('/', [\App\Http\Controllers\Api\v1\MenuController::class, 'adminIndex']);
            Route::post('/', [\App\Http\Controllers\Api\v1\MenuController::class, 'store'])->middleware('scope:' . User::ROLE_ADMIN);
            Route::get('{id}', [\App\Http\Controllers\Api\v1\MenuController::class, 'show'])->whereNumber('id');
            Route::put('{menu}', [\App\Http\Controllers\Api\v1\MenuController::class, 'update'])->whereNumber('menu')->middleware('scope:' . User::ROLE_ADMIN);
            Route::delete('{menu}', [\App\Http\Controllers\Api\v1\MenuController::class, 'destroy'])->whereNumber('menu')->middleware('scope:' . User::ROLE_ADMIN);

            Route::prefix('{menu}/items')->group(function () {
                Route::middleware(['auth:api', 'scope:' . User::ROLE_ADMIN])->group(function () {
                    Route::get('/', [\App\Http\Controllers\Api\v1\MenuItemController::class, 'adminIndex']);
                    Route::post('/', [\App\Http\Controllers\Api\v1\MenuItemController::class, 'store'])->middleware('scope:' . User::ROLE_ADMIN);
                    Route::get('{id}', [\App\Http\Controllers\Api\v1\MenuItemController::class, 'show'])->whereNumber('id');
                    Route::put('{id}', [\App\Http\Controllers\Api\v1\MenuItemController::class, 'update'])->whereNumber('id')->middleware('scope:' . User::ROLE_ADMIN);
                    Route::delete('{id}', [\App\Http\Controllers\Api\v1\MenuItemController::class, 'destroy'])->whereNumber('id')->middleware('scope:' . User::ROLE_ADMIN);
                });
            });
        });
    });
    Route::prefix('menus')->group(function () {
        Route::get('/', [\App\Http\Controllers\Api\v1\MenuController::class, 'index']);
        Route::get('{slug}', [\App\Http\Controllers\Api\v1\MenuController::class, 'frontShow']);
        Route::prefix('{menu}/items')->group(function () {
            Route::middleware(['auth:api', 'scope:' . User::ROLE_ADMIN])->group(function () {
                Route::get('/', [\App\Http\Controllers\Api\v1\MenuItemController::class, 'index']);
                Route::get('{id}', [\App\Http\Controllers\Api\v1\MenuItemController::class, 'frontShow']);
            });
        });
    });
    /**--------------------------------------------------------------------------------
     * menus ROUTES  => END
     * --------------------------------------------------------------------------------*/

    /**--------------------------------------------------------------------------------
     * menus ROUTES  => START
     * --------------------------------------------------------------------------------*/
    Route::prefix('admin/categories')->group(function () {
        Route::middleware(['auth:api', 'scope:' . User::ROLE_ADMIN])->group(function () {
            Route::get('/', [\App\Http\Controllers\Api\v1\CategoryController::class, 'adminIndex']);
            Route::post('/', [\App\Http\Controllers\Api\v1\CategoryController::class, 'store'])->middleware('scope:' . User::ROLE_ADMIN);
            Route::get('{id}', [\App\Http\Controllers\Api\v1\CategoryController::class, 'show'])->whereNumber('id');
            Route::put('{category}', [\App\Http\Controllers\Api\v1\CategoryController::class, 'update'])->whereNumber('category')->middleware('scope:' . User::ROLE_ADMIN);
            Route::delete('{category}', [\App\Http\Controllers\Api\v1\CategoryController::class, 'destroy'])->whereNumber('category')->middleware('scope:' . User::ROLE_ADMIN);
        });
    });
    Route::prefix('categories')->group(function () {
        Route::get('/', [\App\Http\Controllers\Api\v1\CategoryController::class, 'index']);
        Route::get('{category}', [\App\Http\Controllers\Api\v1\CategoryController::class, 'frontShow']);
    });
    /**--------------------------------------------------------------------------------
     * menus ROUTES  => END
     * --------------------------------------------------------------------------------*/

    /**--------------------------------------------------------------------------------
     * product ROUTES  => START
     * --------------------------------------------------------------------------------*/
    Route::prefix('admin/products')->group(function () {
        Route::middleware(['auth:api', 'scope:' . User::ROLE_ADMIN])->group(function () {
            Route::get('/', [\App\Http\Controllers\Api\v1\ProductController::class, 'adminIndex']);
            Route::post('/', [\App\Http\Controllers\Api\v1\ProductController::class, 'store'])->middleware('scope:' . User::ROLE_ADMIN);
            Route::get('{id}', [\App\Http\Controllers\Api\v1\ProductController::class, 'show'])->whereNumber('id');
            Route::put('{id}', [\App\Http\Controllers\Api\v1\ProductController::class, 'update'])->whereNumber('category')->middleware('scope:' . User::ROLE_ADMIN);
            Route::delete('{id}', [\App\Http\Controllers\Api\v1\ProductController::class, 'destroy'])->whereNumber('product')->middleware('scope:' . User::ROLE_ADMIN);
        });
    });
    Route::prefix('products')->group(function () {
        Route::get('/', [\App\Http\Controllers\Api\v1\ProductController::class, 'index']);
        Route::get('{id}', [\App\Http\Controllers\Api\v1\ProductController::class, 'frontShow']);
    });
    /**--------------------------------------------------------------------------------
     * product ROUTES  => END
     * --------------------------------------------------------------------------------*/

    /**--------------------------------------------------------------------------------
     * SocialNetwork  ROUTES  => START
     * --------------------------------------------------------------------------------*/
    Route::prefix('admin/social-networks')->group(function () {
        Route::middleware(['auth:api', 'scope:' . User::ROLE_ADMIN])->group(function () {
            Route::get('/', [\App\Http\Controllers\Api\v1\SocialNetworkController::class, 'adminIndex']);
            Route::post('/', [\App\Http\Controllers\Api\v1\SocialNetworkController::class, 'store'])->middleware('scope:' . User::ROLE_ADMIN);
            Route::get('{id}', [\App\Http\Controllers\Api\v1\SocialNetworkController::class, 'show'])->whereNumber('id');
            Route::put('{id}', [\App\Http\Controllers\Api\v1\SocialNetworkController::class, 'update'])->whereNumber('category')->middleware('scope:' . User::ROLE_ADMIN);
            Route::delete('{id}', [\App\Http\Controllers\Api\v1\SocialNetworkController::class, 'destroy'])->whereNumber('product')->middleware('scope:' . User::ROLE_ADMIN);
        });
    });
    Route::prefix('social-networks')->group(function () {
        Route::get('/', [\App\Http\Controllers\Api\v1\SocialNetworkController::class, 'index']);
        Route::get('{id}', [\App\Http\Controllers\Api\v1\SocialNetworkController::class, 'frontShow']);
    });
    /**--------------------------------------------------------------------------------
     * SocialNetwork  ROUTES  => END
     * --------------------------------------------------------------------------------*/

    /**--------------------------------------------------------------------------------
     * partners  ROUTES  => START
     * --------------------------------------------------------------------------------*/
    Route::prefix('admin/partners')->group(function () {
        Route::middleware(['auth:api', 'scope:' . User::ROLE_ADMIN])->group(function () {
            Route::get('/', [\App\Http\Controllers\Api\v1\PartnerController::class, 'adminIndex']);
            Route::post('/', [\App\Http\Controllers\Api\v1\PartnerController::class, 'store'])->middleware('scope:' . User::ROLE_ADMIN);
            Route::get('{id}', [\App\Http\Controllers\Api\v1\PartnerController::class, 'show'])->whereNumber('id');
            Route::put('{id}', [\App\Http\Controllers\Api\v1\PartnerController::class, 'update'])->whereNumber('category')->middleware('scope:' . User::ROLE_ADMIN);
            Route::delete('{id}', [\App\Http\Controllers\Api\v1\PartnerController::class, 'destroy'])->whereNumber('product')->middleware('scope:' . User::ROLE_ADMIN);
        });
    });
    Route::prefix('partners')->group(function () {
        Route::get('/', [\App\Http\Controllers\Api\v1\PartnerController::class, 'index']);
        Route::get('{id}', [\App\Http\Controllers\Api\v1\PartnerController::class, 'frontShow']);
    });
    /**--------------------------------------------------------------------------------
     * partners  ROUTES  => END
     * --------------------------------------------------------------------------------*/

    /**--------------------------------------------------------------------------------
     * Statistic  ROUTES  => START
     * --------------------------------------------------------------------------------*/
    Route::prefix('admin/statistics')->group(function () {
        Route::middleware(['auth:api', 'scope:' . User::ROLE_ADMIN])->group(function () {
            Route::get('/', [\App\Http\Controllers\Api\v1\StatisticController::class, 'adminIndex']);
            Route::post('/', [\App\Http\Controllers\Api\v1\StatisticController::class, 'store'])->middleware('scope:' . User::ROLE_ADMIN);
            Route::get('{id}', [\App\Http\Controllers\Api\v1\StatisticController::class, 'show'])->whereNumber('id');
            Route::put('{id}', [\App\Http\Controllers\Api\v1\StatisticController::class, 'update'])->whereNumber('category')->middleware('scope:' . User::ROLE_ADMIN);
            Route::delete('{id}', [\App\Http\Controllers\Api\v1\StatisticController::class, 'destroy'])->whereNumber('product')->middleware('scope:' . User::ROLE_ADMIN);
        });
    });
    Route::prefix('statistics')->group(function () {
        Route::get('/', [\App\Http\Controllers\Api\v1\StatisticController::class, 'index']);
        Route::get('{id}', [\App\Http\Controllers\Api\v1\StatisticController::class, 'frontShow']);
    });
    /**--------------------------------------------------------------------------------
     * Statistic  ROUTES  => END
     * --------------------------------------------------------------------------------*/

    /**--------------------------------------------------------------------------------
     * banners  ROUTES  => START
     * --------------------------------------------------------------------------------*/
    Route::prefix('admin/banners')->group(function () {
        Route::middleware(['auth:api', 'scope:' . User::ROLE_ADMIN])->group(function () {
            Route::get('/', [\App\Http\Controllers\Api\v1\BannerController::class, 'adminIndex']);
            Route::post('/', [\App\Http\Controllers\Api\v1\BannerController::class, 'store'])->middleware('scope:' . User::ROLE_ADMIN);
            Route::get('{id}', [\App\Http\Controllers\Api\v1\BannerController::class, 'show'])->whereNumber('id');
            Route::put('{id}', [\App\Http\Controllers\Api\v1\BannerController::class, 'update'])->whereNumber('category')->middleware('scope:' . User::ROLE_ADMIN);
            Route::delete('{id}', [\App\Http\Controllers\Api\v1\BannerController::class, 'destroy'])->whereNumber('product')->middleware('scope:' . User::ROLE_ADMIN);
        });
    });
    Route::prefix('banners')->group(function () {
        Route::get('/', [\App\Http\Controllers\Api\v1\BannerController::class, 'index']);
        Route::get('{id}', [\App\Http\Controllers\Api\v1\BannerController::class, 'frontShow']);
    });
    /**--------------------------------------------------------------------------------
     * banners  ROUTES  => END
     * --------------------------------------------------------------------------------*/

    /**--------------------------------------------------------------------------------
     * certificates  ROUTES  => START
     * --------------------------------------------------------------------------------*/
    Route::prefix('admin/certificates')->group(function () {
        Route::middleware(['auth:api', 'scope:' . User::ROLE_ADMIN])->group(function () {
            Route::get('/', [\App\Http\Controllers\Api\v1\CertificateController::class, 'adminIndex']);
            Route::post('/', [\App\Http\Controllers\Api\v1\CertificateController::class, 'store'])->middleware('scope:' . User::ROLE_ADMIN);
            Route::get('{id}', [\App\Http\Controllers\Api\v1\CertificateController::class, 'show'])->whereNumber('id');
            Route::put('{id}', [\App\Http\Controllers\Api\v1\CertificateController::class, 'update'])->whereNumber('category')->middleware('scope:' . User::ROLE_ADMIN);
            Route::delete('{id}', [\App\Http\Controllers\Api\v1\CertificateController::class, 'destroy'])->whereNumber('product')->middleware('scope:' . User::ROLE_ADMIN);
        });
    });
    Route::prefix('certificates')->group(function () {
        Route::get('/', [\App\Http\Controllers\Api\v1\CertificateController::class, 'index']);
        Route::get('{id}', [\App\Http\Controllers\Api\v1\CertificateController::class, 'frontShow']);
    });
    /**--------------------------------------------------------------------------------
     * certificates  ROUTES  => END
     * --------------------------------------------------------------------------------*/

    /**--------------------------------------------------------------------------------
     * histories  ROUTES  => START
     * --------------------------------------------------------------------------------*/
    Route::prefix('admin/histories')->group(function () {
        Route::middleware(['auth:api', 'scope:' . User::ROLE_ADMIN])->group(function () {
            Route::get('/', [\App\Http\Controllers\Api\v1\HistoryController::class, 'adminIndex']);
            Route::post('/', [\App\Http\Controllers\Api\v1\HistoryController::class, 'store'])->middleware('scope:' . User::ROLE_ADMIN);
            Route::get('{id}', [\App\Http\Controllers\Api\v1\HistoryController::class, 'show'])->whereNumber('id');
            Route::put('{id}', [\App\Http\Controllers\Api\v1\HistoryController::class, 'update'])->whereNumber('category')->middleware('scope:' . User::ROLE_ADMIN);
            Route::delete('{id}', [\App\Http\Controllers\Api\v1\HistoryController::class, 'destroy'])->whereNumber('product')->middleware('scope:' . User::ROLE_ADMIN);
        });
    });
    Route::prefix('histories')->group(function () {
        Route::get('/', [\App\Http\Controllers\Api\v1\HistoryController::class, 'index']);
        Route::get('{id}', [\App\Http\Controllers\Api\v1\HistoryController::class, 'frontShow']);
    });
    /**--------------------------------------------------------------------------------
     * histories  ROUTES  => END
     * --------------------------------------------------------------------------------*/

    /**--------------------------------------------------------------------------------
     * employees  ROUTES  => START
     * --------------------------------------------------------------------------------*/
    Route::prefix('admin/employees')->group(function () {
        Route::middleware(['auth:api', 'scope:' . User::ROLE_ADMIN])->group(function () {
            Route::get('/', [\App\Http\Controllers\Api\v1\EmployeeController::class, 'adminIndex']);
            Route::post('/', [\App\Http\Controllers\Api\v1\EmployeeController::class, 'store'])->middleware('scope:' . User::ROLE_ADMIN);
            Route::get('{id}', [\App\Http\Controllers\Api\v1\EmployeeController::class, 'show'])->whereNumber('id');
            Route::put('{id}', [\App\Http\Controllers\Api\v1\EmployeeController::class, 'update'])->whereNumber('category')->middleware('scope:' . User::ROLE_ADMIN);
            Route::delete('{id}', [\App\Http\Controllers\Api\v1\EmployeeController::class, 'destroy'])->whereNumber('product')->middleware('scope:' . User::ROLE_ADMIN);
        });
    });
    Route::prefix('employees')->group(function () {
        Route::get('/', [\App\Http\Controllers\Api\v1\EmployeeController::class, 'index']);
        Route::get('{id}', [\App\Http\Controllers\Api\v1\EmployeeController::class, 'frontShow']);
    });
    /**--------------------------------------------------------------------------------
     * employees  ROUTES  => END
     * --------------------------------------------------------------------------------*/

    /**--------------------------------------------------------------------------------
     * companies  ROUTES  => START
     * --------------------------------------------------------------------------------*/
    Route::prefix('admin/companies')->group(function () {
        Route::middleware(['auth:api', 'scope:' . User::ROLE_ADMIN])->group(function () {
            Route::get('/', [\App\Http\Controllers\Api\v1\CompanyController::class, 'adminIndex']);
            Route::post('/', [\App\Http\Controllers\Api\v1\CompanyController::class, 'store'])->middleware('scope:' . User::ROLE_ADMIN);
            Route::get('{id}', [\App\Http\Controllers\Api\v1\CompanyController::class, 'show'])->whereNumber('id');
            Route::put('{id}', [\App\Http\Controllers\Api\v1\CompanyController::class, 'update'])->whereNumber('category')->middleware('scope:' . User::ROLE_ADMIN);
            Route::delete('{id}', [\App\Http\Controllers\Api\v1\CompanyController::class, 'destroy'])->whereNumber('product')->middleware('scope:' . User::ROLE_ADMIN);
        });
    });
    Route::prefix('companies')->group(function () {
        Route::get('/', [\App\Http\Controllers\Api\v1\CompanyController::class, 'index']);
        Route::get('{id}', [\App\Http\Controllers\Api\v1\CompanyController::class, 'frontShow']);
    });
    /**--------------------------------------------------------------------------------
     * companies  ROUTES  => END
     * --------------------------------------------------------------------------------*/
    /**--------------------------------------------------------------------------------
     * agreements  ROUTES  => START
     * --------------------------------------------------------------------------------*/
    Route::prefix('admin/agreements')->group(function () {
        Route::middleware(['auth:api', 'scope:' . User::ROLE_ADMIN])->group(function () {
            Route::get('/', [\App\Http\Controllers\Api\v1\AgreementController::class, 'adminIndex']);
            Route::post('/', [\App\Http\Controllers\Api\v1\AgreementController::class, 'store'])->middleware('scope:' . User::ROLE_ADMIN);
            Route::get('{id}', [\App\Http\Controllers\Api\v1\AgreementController::class, 'show'])->whereNumber('id');
            Route::put('{id}', [\App\Http\Controllers\Api\v1\AgreementController::class, 'update'])->whereNumber('category')->middleware('scope:' . User::ROLE_ADMIN);
            Route::delete('{id}', [\App\Http\Controllers\Api\v1\AgreementController::class, 'destroy'])->whereNumber('product')->middleware('scope:' . User::ROLE_ADMIN);
        });
    });
    Route::prefix('agreements')->group(function () {
        Route::get('/', [\App\Http\Controllers\Api\v1\AgreementController::class, 'index']);
        Route::get('{id}', [\App\Http\Controllers\Api\v1\AgreementController::class, 'frontShow']);
    });
    /**--------------------------------------------------------------------------------
     * agreements  ROUTES  => END
     * --------------------------------------------------------------------------------*/
    /**--------------------------------------------------------------------------------
     * review-uzb  ROUTES  => START
     * --------------------------------------------------------------------------------*/
    Route::prefix('admin/review-uzb')->group(function () {
        Route::middleware(['auth:api', 'scope:' . User::ROLE_ADMIN])->group(function () {
            Route::get('/', [\App\Http\Controllers\Api\v1\ReviewUzbController::class, 'adminIndex']);
            Route::post('/', [\App\Http\Controllers\Api\v1\ReviewUzbController::class, 'store'])->middleware('scope:' . User::ROLE_ADMIN);
            Route::get('{id}', [\App\Http\Controllers\Api\v1\ReviewUzbController::class, 'show'])->whereNumber('id');
            Route::put('{id}', [\App\Http\Controllers\Api\v1\ReviewUzbController::class, 'update'])->whereNumber('category')->middleware('scope:' . User::ROLE_ADMIN);
            Route::delete('{id}', [\App\Http\Controllers\Api\v1\ReviewUzbController::class, 'destroy'])->whereNumber('product')->middleware('scope:' . User::ROLE_ADMIN);
        });
    });
    Route::prefix('review-uzb')->group(function () {
        Route::get('/', [\App\Http\Controllers\Api\v1\ReviewUzbController::class, 'index']);
        Route::get('{id}', [\App\Http\Controllers\Api\v1\ReviewUzbController::class, 'frontShow']);
    });
    /**--------------------------------------------------------------------------------
     * review-uzb  ROUTES  => END
     * --------------------------------------------------------------------------------*/
    /**--------------------------------------------------------------------------------
     * Region  ROUTES  => START
     * --------------------------------------------------------------------------------*/
    Route::prefix('admin/regions')->group(function () {
        Route::middleware(['auth:api', 'scope:' . User::ROLE_ADMIN])->group(function () {
            Route::get('/', [\App\Http\Controllers\Api\v1\RegionController::class, 'adminIndex']);
            Route::post('/', [\App\Http\Controllers\Api\v1\RegionController::class, 'store'])->middleware('scope:' . User::ROLE_ADMIN);
            Route::get('{id}', [\App\Http\Controllers\Api\v1\RegionController::class, 'show'])->whereNumber('id');
            Route::put('{id}', [\App\Http\Controllers\Api\v1\RegionController::class, 'update'])->whereNumber('category')->middleware('scope:' . User::ROLE_ADMIN);
            Route::delete('{id}', [\App\Http\Controllers\Api\v1\RegionController::class, 'destroy'])->whereNumber('product')->middleware('scope:' . User::ROLE_ADMIN);
        });
    });
    Route::prefix('regions')->group(function () {
        Route::get('/', [\App\Http\Controllers\Api\v1\RegionController::class, 'index']);
        Route::get('{id}', [\App\Http\Controllers\Api\v1\RegionController::class, 'frontShow']);
    });
    /**--------------------------------------------------------------------------------
     * Region  ROUTES  => END
     * --------------------------------------------------------------------------------*/
    /**--------------------------------------------------------------------------------
     * Feedback  ROUTES  => START
     * --------------------------------------------------------------------------------*/
    Route::prefix('admin/feedbacks')->group(function () {
        Route::middleware(['auth:api', 'scope:' . User::ROLE_ADMIN])->group(function () {
            Route::get('/', [\App\Http\Controllers\Api\v1\FeedbackController::class, 'adminIndex']);
            Route::get('{id}', [\App\Http\Controllers\Api\v1\FeedbackController::class, 'show'])->whereNumber('id');
            Route::put('{id}', [\App\Http\Controllers\Api\v1\FeedbackController::class, 'update'])->whereNumber('category')->middleware('scope:' . User::ROLE_ADMIN);
            Route::delete('{id}', [\App\Http\Controllers\Api\v1\FeedbackController::class, 'destroy'])->whereNumber('product')->middleware('scope:' . User::ROLE_ADMIN);
        });
    });
    Route::prefix('feedbacks')->group(function () {
        Route::post('/', [\App\Http\Controllers\Api\v1\FeedbackController::class, 'store']);
    });
    /**--------------------------------------------------------------------------------
     * Feedback  ROUTES  => END
     * --------------------------------------------------------------------------------*/
});
