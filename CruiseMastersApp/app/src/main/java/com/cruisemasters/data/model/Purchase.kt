package com.cruisemasters.data.model

import androidx.room.Entity
import androidx.room.PrimaryKey

@Entity(tableName = "purchases")
data class Purchase(
    @PrimaryKey(autoGenerate = true)
    val purchaseID: Int = 0,
    val vehiclename: String,
    val purchasedate: String,
    val email: String,
    val status: String = "Pending"
)
