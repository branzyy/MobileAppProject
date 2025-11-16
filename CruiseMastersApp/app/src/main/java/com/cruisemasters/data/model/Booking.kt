package com.cruisemasters.data.model

import androidx.room.Entity
import androidx.room.PrimaryKey

@Entity(tableName = "bookings")
data class Booking(
    @PrimaryKey(autoGenerate = true)
    val bookingsID: Int = 0,
    val vehiclename: String,
    val pickupdate: String,
    val returndate: String,
    val email: String,
    val status: String = "Pending"
)
