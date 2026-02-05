<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProduitController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('categories', CategoryController::class);
Route::resource('clients', ClientController::class);
Route::resource('produits', ProduitController::class);
Route::resource('commandes', CommandeController::class);
Route::get('commandes-search', [CommandeController::class, 'search'])->name('commandes.search');
Route::post('commandes/{commande}/produits', [CommandeController::class, 'addProduit'])->name('commandes.addProduit');
Route::put('commandes/{commande}/produits/{produit}', [CommandeController::class, 'updateProduit'])->name('commandes.updateProduit');
Route::delete('commandes/{commande}/produits/{produit}', [CommandeController::class, 'removeProduit'])->name('commandes.removeProduit');
