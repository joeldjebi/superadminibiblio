<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuteurController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\TypePublicationController;
use App\Http\Controllers\DeviseController;
use App\Http\Controllers\PaysController;
use App\Http\Controllers\LangueController;
use App\Http\Controllers\EditeurController;
use App\Http\Controllers\ForfaitController;
use App\Http\Controllers\LivreController;
use App\Http\Controllers\JetonController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PubliciteController;
use App\Http\Controllers\ParoleForteController;
use App\Http\Controllers\AbonnementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::group(['middleware' => ['auth']], function (){

    Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [DashboardController::class, 'logout'])->name('logout');


    Route::get('/les-jetons', [JetonController::class, 'index'])->name('jeton.index');
    Route::post('/store-jetons', [JetonController::class, 'store'])->name('jeton.store');
    Route::post('/update-jetons/{id}', [JetonController::class, 'update'])->name('jeton.update');
    Route::delete('/destroy-jetons/{id}', [JetonController::class, 'destroy'])->name('jeton.destroy');

    Route::get('/les-auteurs', [AuteurController::class, 'index'])->name('auteur.index');
    Route::post('/store-auteurs', [AuteurController::class, 'store'])->name('auteur.store');
    Route::post('/update-auteurs/{id}', [AuteurController::class, 'update'])->name('auteur.update');
    Route::delete('/destroy-auteurs/{id}', [AuteurController::class, 'destroy'])->name('auteur.destroy');

    Route::get('/les-categories-de-livre', [CategorieController::class, 'index'])->name('categorie-livre.index');
    Route::post('/store-categorie-livre', [CategorieController::class, 'store'])->name('categorie-livre.store');
    Route::post('/update-categorie-livre/{id}', [CategorieController::class, 'update'])->name('categorie-livre.update');
    Route::delete('/destroy-categorie-livre/{id}', [CategorieController::class, 'destroy'])->name('categorie-livre.destroy');

    Route::get('/les-paroles-forte', [ParoleForteController::class, 'index'])->name('parole-forte.index');
    Route::post('/store-parole-forte', [ParoleForteController::class, 'store'])->name('parole-forte.store');
    Route::post('/update-parole-forte/{id}', [ParoleForteController::class, 'update'])->name('parole-forte.update');
    Route::delete('/destroy-parole-forte/{id}', [ParoleForteController::class, 'destroy'])->name('parole-forte.destroy');

    Route::get('/les-type-de-publications', [TypePublicationController::class, 'index'])->name('type-de-publication.index');
    Route::post('/store-type-de-publication', [TypePublicationController::class, 'store'])->name('type-de-publication.store');
    Route::post('/update-type-de-publication/{id}', [TypePublicationController::class, 'update'])->name('type-de-publication.update');
    Route::delete('/destroy-type-de-publication/{id}', [TypePublicationController::class, 'destroy'])->name('type-de-publication.destroy');

    Route::get('/liste-des-devises', [DeviseController::class, 'index'])->name('devise.index');
    Route::post('/store-devise', [DeviseController::class, 'store'])->name('devise.store');
    Route::post('/update-devise/{id}', [DeviseController::class, 'update'])->name('devise.update');
    Route::delete('/destroy-devise/{id}', [DeviseController::class, 'destroy'])->name('devise.destroy');

    Route::get('/liste-des-pays', [PaysController::class, 'index'])->name('pays.index');
    Route::post('/store-pays', [PaysController::class, 'store'])->name('pays.store');
    Route::post('/update-pays/{id}', [PaysController::class, 'update'])->name('pays.update');
    Route::delete('/destroy-pays/{id}', [PaysController::class, 'destroy'])->name('pays.destroy');

    Route::get('/liste-des-publicite', [PubliciteController::class, 'index'])->name('publicite.index');
    Route::post('/store-publicite', [PubliciteController::class, 'store'])->name('publicite.store');
    Route::post('/update-publicite/{id}', [PubliciteController::class, 'update'])->name('publicite.update');
    Route::delete('/destroy-publicite/{id}', [PubliciteController::class, 'destroy'])->name('publicite.destroy');

    Route::get('/liste-des-langues', [LangueController::class, 'index'])->name('langue.index');
    Route::post('/store-langue', [LangueController::class, 'store'])->name('langue.store');
    Route::post('/update-langue/{id}', [LangueController::class, 'update'])->name('langue.update');
    Route::delete('/destroy-langue/{id}', [LangueController::class, 'destroy'])->name('langue.destroy');

    Route::get('/liste-des-editeurs', [EditeurController::class, 'index'])->name('editeur.index');
    Route::post('/store-editeur', [EditeurController::class, 'store'])->name('editeur.store');
    Route::post('/update-editeur/{id}', [EditeurController::class, 'update'])->name('editeur.update');
    Route::delete('/destroy-editeur/{id}', [EditeurController::class, 'destroy'])->name('editeur.destroy');

    Route::get('/liste-des-forfaits', [ForfaitController::class, 'index'])->name('forfait.index');
    Route::post('/store-forfait', [ForfaitController::class, 'store'])->name('forfait.store');
    Route::post('/update-forfait/{id}', [ForfaitController::class, 'update'])->name('forfait.update');
    Route::delete('/destroy-forfait/{id}', [ForfaitController::class, 'destroy'])->name('forfait.destroy');

    Route::get('/liste-des-livres', [LivreController::class, 'index'])->name('livre.index');
    Route::get('/create-livre', [LivreController::class, 'create'])->name('livre.create');
    Route::get('/edit-livre/{id}', [LivreController::class, 'edit'])->name('livre.edit');
    Route::post('/store-livre', [LivreController::class, 'store'])->name('livre.store');
    Route::post('/update-livre/{id}', [LivreController::class, 'update'])->name('livre.update');
    Route::delete('/destroy-livre/{id}', [LivreController::class, 'destroy'])->name('livre.destroy');
    Route::get('/details-du-livre/{id}', [LivreController::class, 'show'])->name('livre.show');

    // Route pour supprimer un épisode
    Route::delete('/livre/{livreId}/episode/{episodeId}', [LivreController::class, 'destroyEpisode']);
    // Route pour mettre a jour un épisode
    Route::post('/livre/{livreId}/episode-update/{episodeId}', [LivreController::class, 'handleEpisodeUpdateOnly'])->name('livre.episode-update');
    // Route pour enregistrer épisode
    Route::post('/livre/{livreId}/episode-store', [LivreController::class, 'handleEpisodeStoreOnly'])->name('livre.episode-store');

    // Route pour supprimer un chapitre
    Route::delete('/livre/{livreId}/chapitre/{chapitreId}', [LivreController::class, 'destroyChapitre']);
    // Route pour mettre a jour un chapitre
    Route::post('/livre/{livreId}/chapitre-update/{chapitreId}', [LivreController::class, 'handleChapitreUpdateOnly'])->name('livre.chapitre-update');
    // Route pour enregistrer chapitre
    Route::post('/livre/{livreId}/chapitre-store', [LivreController::class, 'handleChapitreStoreOnly'])->name('livre.chapitre-store');
    // Route pour afficher les livres achetés
    Route::get('/livre/achetes', [LivreController::class, 'indexLivreAchete'])->name('livre.achetes');

    Route::get('/liste-des-utilisateurs', [UserController::class, 'index'])->name('utilisateur.index');
    Route::get('/details-utilisateur/{id}', [UserController::class, 'show'])->name('utilisateur.show');

    Route::get('/historique-achat-de-talent', [AbonnementController::class, 'indexTalent'])->name('historique-achat.talent');
    Route::get('/historique-abonnement', [AbonnementController::class, 'indexAbonnement'])->name('historique.abonnement');
    Route::get('/achat-de-livre', [AbonnementController::class, 'indexAchatLivre'])->name('achat.livre');

});

Route::get('/', [AuthController::class, 'showlogin'])->name('login');

Route::get('/login', [AuthController::class, 'showlogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('logins');

Route::get('/register', [AuthController::class, 'showregister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('registers');