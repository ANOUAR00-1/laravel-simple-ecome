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

// Clients export
Route::get('clients-export/print', [ClientController::class, 'exportPrint'])->name('clients.export.print');
Route::get('clients-export/pdf', [ClientController::class, 'exportPdf'])->name('clients.export.pdf');

// Categories export
Route::get('categories-export/print', [CategoryController::class, 'exportPrint'])->name('categories.export.print');
Route::get('categories-export/pdf', [CategoryController::class, 'exportPdf'])->name('categories.export.pdf');

// Produits export
Route::get('produits-export/print', [ProduitController::class, 'exportPrint'])->name('produits.export.print');
Route::get('produits-export/pdf', [ProduitController::class, 'exportPdf'])->name('produits.export.pdf');

// Commandes search
Route::get('commandes-search', [CommandeController::class, 'search'])->name('commandes.search');

// Commandes products management
Route::post('commandes/{commande}/produits', [CommandeController::class, 'addProduit'])->name('commandes.addProduit');
Route::put('commandes/{commande}/produits/{produit}', [CommandeController::class, 'updateProduit'])->name('commandes.updateProduit');
Route::delete('commandes/{commande}/produits/{produit}', [CommandeController::class, 'removeProduit'])->name('commandes.removeProduit');

// Commandes status management
Route::post('commandes/{commande}/validate', [CommandeController::class, 'validateOrder'])->name('commandes.validate');
Route::post('commandes/{commande}/cancel', [CommandeController::class, 'cancel'])->name('commandes.cancel');
Route::post('commandes/{commande}/deliver', [CommandeController::class, 'deliver'])->name('commandes.deliver');
Route::post('commandes/{commande}/close', [CommandeController::class, 'close'])->name('commandes.close');

// Commandes print and export
Route::get('commandes/{commande}/print', [CommandeController::class, 'print'])->name('commandes.print');
Route::get('commandes/{commande}/pdf', [CommandeController::class, 'exportPdf'])->name('commandes.pdf');

// Bulk export filtered orders
Route::get('commandes-export/print', [CommandeController::class, 'exportFilteredPrint'])->name('commandes.export.print');
Route::get('commandes-export/pdf', [CommandeController::class, 'exportFilteredPdf'])->name('commandes.export.pdf');

// Commandes archive
Route::get('commandes-archived', [CommandeController::class, 'archived'])->name('commandes.archived');
Route::post('commandes/{commande}/archive', [CommandeController::class, 'archive'])->name('commandes.archive');
Route::post('commandes/{commande}/restore', [CommandeController::class, 'restore'])->name('commandes.restore');
