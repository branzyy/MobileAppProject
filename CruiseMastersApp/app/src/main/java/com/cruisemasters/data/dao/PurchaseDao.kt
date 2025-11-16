package com.cruisemasters.data.dao

import androidx.room.Dao
import androidx.room.Insert
import androidx.room.Query
import com.cruisemasters.data.model.Purchase

@Dao
interface PurchaseDao {
    @Insert
    suspend fun insertPurchase(purchase: Purchase)

    @Query("SELECT * FROM purchases WHERE email = :email ORDER BY purchaseID DESC")
    suspend fun getPurchasesByEmail(email: String): List<Purchase>
}
