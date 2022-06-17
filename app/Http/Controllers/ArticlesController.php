<?php

namespace App\Http\Controllers;
use Illuminate\Support\Arr;
use App\Models\Article;
use App\Models\Loan;
use App\Models\Academy;
use App\Models\Warehouse;
use Auth;

use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    public function pullArticles()
    {
        //Get all the articles that are in the warehouses of the assigned academy
        if (Auth::user()->academy_id != NULL) {
            $academyWarehouses = Warehouse::where('academy_id', Auth::user()->academy_id)->get('id')->toArray();
            $whIdArray = [];
            for ($i=0; $i < count($academyWarehouses); $i++) { 
                array_push($whIdArray, $academyWarehouses[$i]['id']);
            }
            $articles = Article::all()->whereIn('warehouse_id', $whIdArray);

        } else {
            $articles = Article::all();
        }
        
        //Create dummy dates for the articles 
        $lastKey = $articles->keys()->last() + 1;
        for ($i=0; $i < $lastKey; $i++) { 
            if (Arr::exists($articles, $i)) {
                $articles[$i]->created_at = date_create($articles[$i]->created_at);
                //Pulls the amount of the product that is lent out
                $loans = Loan::all()->where('article_id', $articles[$i]->id);
                if ($loans->isNotEmpty()) {
                    foreach ($loans as $arr) {
                        $articles[$i]->lent_out = $articles[$i]->lent_out + $arr->amount;
                    }
                    
                }
                $articles[$i]->academy_name = $articles[$i]->warehouse->name;
            }
        }  

        return $articles;
        
    }
    
    public function viewArticlesFA()
    {
        return view('viewArticle', [
            'articles' => ArticlesController::pullArticles()
        ]);
        
    }

    public function showArticles()
    {
        return view('requestArticle', [
            'articles' => ArticlesController::pullArticles()
        ]);
        
    }

    public function requestArticle(Request $request)
    {
        //Get variables from form
        $articleId = $request->post('requestedId');
        $arrayKey = $articleId - 1;
        $userId = $request->post('userId');
        $amount = $request->post('requestedAmount');
        $article = Article::all()->where('id', $articleId);
        // Calculate the new amount by getting the old amount and subtracting the amount requested for the loan
        
            $article[$arrayKey]->total_amount = $article[$arrayKey]->total_amount - $amount;
            $article[$arrayKey]->save();
            Loan::create(
                ['user_id' => $userId,
                 'article_id' => $articleId,
                 'amount' =>  $amount,
                 'loaning_start' => '2022-05-10 20:24:26.000000',
                 'loaning_end' => '2022-05-10 20:24:26.000000']
            );
        
        
        // //Redirects the user to the article overview
        return redirect()->route('show.articles');
    }
}