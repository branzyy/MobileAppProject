package com.cruisemasters.repository

import com.cruisemasters.data.AppDatabase
import com.cruisemasters.data.model.Purchase

class PurchaseRepository(private val database: AppDatabase) {

    suspend fun insertPurchase(purchase: Purchase) {
        database.purchaseDao().insertPurchase(purchase)
    }

    suspend fun getPurchasesByEmail(email: String): List<Purchase> {
        return database.purchaseDao().getPurchasesByEmail(email)
    }
}
