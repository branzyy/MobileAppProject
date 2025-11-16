# TODO: CruiseMasters Android App Development

## Project Setup
- [x] Create new Android project directory (CruiseMastersApp)
- [x] Set up app/build.gradle with dependencies (Room, ViewModel, LiveData, Navigation, RecyclerView, Material Design)
- [x] Configure AndroidManifest.xml
- [x] Set up basic project structure (src/main/java, res, etc.)

## Room Database Implementation
- [x] Create Room entities: User.kt, Car.kt, Purchase.kt, Booking.kt
- [x] Create DAOs: UserDao.kt, CarDao.kt, PurchaseDao.kt, BookingDao.kt
- [x] Create AppDatabase.kt with Room database setup
- [x] Implement data pre-population for cars on first launch

## MVVM Architecture
- [x] Create ViewModels: LoginViewModel.kt, CarViewModel.kt, ProfileViewModel.kt
- [x] Implement Repository classes for data access
- [x] Set up LiveData for reactive UI updates

## Activities and UI
- [ ] Create LoginActivity.kt and activity_login.xml
- [ ] Create SignupActivity.kt and activity_signup.xml
- [ ] Create CarListActivity.kt and activity_car_list.xml (with RecyclerView)
- [ ] Create CarDetailsActivity.kt and activity_car_details.xml
- [ ] Create ProfileActivity.kt and activity_profile.xml (with RecyclerView for purchases/bookings)
- [ ] Create item_car.xml for RecyclerView item
- [ ] Create item_purchase.xml and item_booking.xml for profile lists

## Navigation
- [ ] Set up Navigation Component with nav_graph.xml
- [ ] Implement navigation between activities
- [ ] Handle back navigation and session management

## Authentication and Session
- [ ] Implement login/signup logic with Room
- [ ] Use SharedPreferences for user session storage
- [ ] Add logout functionality

## Features Implementation
- [ ] Car list display with images (use drawable resources)
- [ ] Car details view with purchase/book buttons
- [ ] Purchase confirmation dialog and insertion
- [ ] Booking with date selection and insertion
- [ ] Profile view for user's purchases and bookings
- [ ] Basic validation and error handling

## Testing and Polish
- [ ] Test all features on emulator
- [ ] Handle edge cases (no data, invalid inputs)
- [ ] Add basic styling and Material Design themes
- [ ] Ensure app works offline (Room local storage)
