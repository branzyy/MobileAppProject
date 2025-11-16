package com.cruisemasters.data.dao

import androidx.room.Dao
import androidx.room.Insert
import androidx.room.Query
import com.cruisemasters.data.model.Booking

@Dao
interface BookingDao {
    @Insert
    suspend fun insertBooking(booking: Booking)

    @Query("SELECT * FROM bookings WHERE email = :email ORDER BY bookingsID DESC")
    suspend fun getBookingsByEmail(email: String): List<Booking>
}
