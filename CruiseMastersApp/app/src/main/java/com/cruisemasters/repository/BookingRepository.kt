package com.cruisemasters.repository

import com.cruisemasters.data.AppDatabase
import com.cruisemasters.data.model.Booking

class BookingRepository(private val database: AppDatabase) {

    suspend fun insertBooking(booking: Booking) {
        database.bookingDao().insertBooking(booking)
    }

    suspend fun getBookingsByEmail(email: String): List<Booking> {
        return database.bookingDao().getBookingsByEmail(email)
    }
}
