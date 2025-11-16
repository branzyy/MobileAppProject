package com.cruisemasters.viewmodel

import android.app.Application
import androidx.lifecycle.AndroidViewModel
import androidx.lifecycle.LiveData
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.viewModelScope
import com.cruisemasters.data.AppDatabase
import com.cruisemasters.data.model.Booking
import com.cruisemasters.data.model.Purchase
import com.cruisemasters.repository.BookingRepository
import com.cruisemasters.repository.PurchaseRepository
import kotlinx.coroutines.launch

class ProfileViewModel(application: Application) : AndroidViewModel(application) {

    private val purchaseRepository: PurchaseRepository
    private val bookingRepository: BookingRepository

    private val _purchases = MutableLiveData<List<Purchase>>()
    val purchases: LiveData<List<Purchase>> get() = _purchases

    private val _bookings = MutableLiveData<List<Booking>>()
    val bookings: LiveData<List<Booking>> get() = _bookings

    init {
        val database = AppDatabase.getDatabase(application, viewModelScope)
        purchaseRepository = PurchaseRepository(database)
        bookingRepository = BookingRepository(database)
    }

    fun loadPurchases(email: String) {
        viewModelScope.launch {
            try {
                val purchaseList = purchaseRepository.getPurchasesByEmail(email)
                _purchases.value = purchaseList
            } catch (e: Exception) {
                _purchases.value = emptyList()
            }
        }
    }

    fun loadBookings(email: String) {
        viewModelScope.launch {
            try {
                val bookingList = bookingRepository.getBookingsByEmail(email)
                _bookings.value = bookingList
            } catch (e: Exception) {
                _bookings.value = emptyList()
            }
        }
    }

    fun addPurchase(purchase: Purchase) {
        viewModelScope.launch {
            try {
                purchaseRepository.insertPurchase(purchase)
                // Reload purchases after adding
                loadPurchases(purchase.email)
            } catch (e: Exception) {
                // Handle error
            }
        }
    }

    fun addBooking(booking: Booking) {
        viewModelScope.launch {
            try {
                bookingRepository.insertBooking(booking)
                // Reload bookings after adding
                loadBookings(booking.email)
            } catch (e: Exception) {
                // Handle error
            }
        }
    }
}
