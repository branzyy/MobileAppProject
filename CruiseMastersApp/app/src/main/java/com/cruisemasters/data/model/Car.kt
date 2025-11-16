package com.cruisemasters.data.model

import androidx.room.Entity
import androidx.room.PrimaryKey

@Entity(tableName = "cars")
data class Car(
    @PrimaryKey
    val carId: Int,
    val name: String,
    val year_of_make: Int,
    val mileage: String,
    val price: String,
    val image: String
)
