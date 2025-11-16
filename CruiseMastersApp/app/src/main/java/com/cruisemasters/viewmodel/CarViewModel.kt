package com.cruisemasters.viewmodel

import android.app.Application
import androidx.lifecycle.AndroidViewModel
import androidx.lifecycle.LiveData
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.viewModelScope
import com.cruisemasters.data.AppDatabase
import com.cruisemasters.data.model.Car
import com.cruisemasters.repository.CarRepository
import kotlinx.coroutines.launch

class CarViewModel(application: Application) : AndroidViewModel(application) {

    private val repository: CarRepository
    private val _cars = MutableLiveData<List<Car>>()
    val cars: LiveData<List<Car>> get() = _cars

    private val _car = MutableLiveData<Car?>()
    val car: LiveData<Car?> get() = _car

    init {
        val database = AppDatabase.getDatabase(application, viewModelScope)
        repository = CarRepository(database)
        loadCars()
    }

    private fun loadCars() {
        viewModelScope.launch {
            try {
                val carList = repository.getAllCars()
                _cars.value = carList
            } catch (e: Exception) {
                _cars.value = emptyList()
            }
        }
    }

    fun getCarById(carId: Int) {
        viewModelScope.launch {
            try {
                val car = repository.getCarById(carId)
                _car.value = car
            } catch (e: Exception) {
                _car.value = null
            }
        }
    }
}
