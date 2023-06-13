<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['namespace'=>'App\Http\Controllers'],function(){
   Route::group(['middleware'=>['guest']],function(){
      Route::get('/','LoginController@show')
          ->name('login');
      Route::post('/','LoginController@login')
          ->name('login.submit');
   });
   Route::group(['middleware'=>['auth']],function (){
      Route::get('dashboard','DashboardController@index')
          ->name('dashboard');
      Route::group(['middleware'=>['admin']],function(){
          Route::resource('user-management','UserManagementController');
          Route::resource('category','CategoryController');
          Route::resource('website','WebsiteController');
          Route::resource('topic-research','UrlTopicResearchController');
          Route::get('topic-research-delete/{id?}','UrlTopicResearchController@delete')
          ->name('delete_topic_research');
          Route::get('topic-research-clone','UrlTopicResearchController@cloneTopicResearch')
          ->name('clone_topic_research');
          Route::get('crawler/{website?}','CrawlerController@index')
              ->name('crawler');
          Route::get('article-writing-report','reportController@index')
              ->name('report');
      });
       Route::prefix('common')->group(function(){
           Route::get('/categories','CommonController@categories')
               ->name('get_categories');
           Route::get('/websites','CommonController@websites')
               ->name('get_websites');
           Route::get('/check-keywords/{id?}','CommonController@checkKeywordExits')
               ->name('check_keywords');
       });
      Route::prefix('writer')->group(function(){
             Route::get('topic-research','WriterController@topicResearch')
             ->name('writer_topic_research');
             Route::get('topic-research-details/{id?}','WriterController@topicResearchDetails')
             ->name('writer_topic_research_details');
             Route::get('topic-research-action/{id?}','WriterController@writerAction')
             ->name('writer_action');
          });
      Route::prefix('report')->group(function(){
             Route::get('writing-report','ReportController@writingReport')
             ->name('writing_report');
          });
      Route::get('logout',function (){
          \Illuminate\Support\Facades\Auth::logout();
          return redirect()
              ->route('login');
      })
          ->name('logout');
   });
});
