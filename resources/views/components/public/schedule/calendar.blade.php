{{-- resources/views/components/public/schedule/calendar.blade.php --}}

@props(['calendarData'])

<div x-data="calendar()" 
     x-init="initCalendar({{ $calendarData['month'] }}, {{ $calendarData['year'] }})"
     class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-4">
    
    {{-- Header --}}
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
            <span x-text="months[currentMonth]"></span> <span x-text="currentYear"></span>
        </h3>
        <div class="flex space-x-2">
            <button @click="prevMonth()" 
                    class="p-2 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition duration-150">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            <button @click="today()" 
                    class="px-3 py-1 text-sm text-teal-600 dark:text-teal-400 hover:bg-teal-50 dark:hover:bg-teal-900/30 rounded-lg transition duration-150">
                Hari Ini
            </button>
            <button @click="nextMonth()" 
                    class="p-2 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition duration-150">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Days of Week --}}
    <div class="grid grid-cols-7 gap-1 mb-2">
        @foreach(['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'] as $day)
            <div class="text-center text-xs font-medium text-gray-500 dark:text-gray-400 py-1">
                {{ $day }}
            </div>
        @endforeach
    </div>

    {{-- Calendar Grid --}}
    <div class="grid grid-cols-7 gap-1">
        <template x-for="(day, index) in days" :key="index">
            <div @click="selectDate(day)"
                 :class="{
                     'bg-[#036672] text-white rounded-lg': day.isToday,
                     'hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer': !day.isOtherMonth,
                     'text-gray-400 dark:text-gray-600': day.isOtherMonth,
                     'font-semibold': day.hasEvent,
                     'ring-2 ring-teal-500 ring-offset-2': day.isSelected
                 }"
                 class="relative p-2 text-center rounded-lg transition duration-150 min-h-[40px] flex flex-col items-center justify-center">
                
                <span class="text-sm" x-text="day.day"></span>
                
                {{-- Event Indicator --}}
                <div x-show="day.hasEvent" class="absolute bottom-1">
                    <div class="w-1.5 h-1.5 bg-teal-500 rounded-full"></div>
                </div>
            </div>
        </template>
    </div>

    {{-- Events on Selected Date --}}
    <div x-show="selectedDateEvents.length > 0" class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            Kegiatan pada <span x-text="selectedDateText"></span>
        </h4>
        <div class="space-y-2">
            <template x-for="event in selectedDateEvents" :key="event.id">
                <div class="flex items-center justify-between p-2 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <div>
                        <span class="text-sm font-medium text-gray-900 dark:text-white" x-text="event.nama_kegiatan"></span>
                        <span class="text-xs text-gray-500 dark:text-gray-400 ml-2" x-text="event.lokasi"></span>
                    </div>
                    <span class="px-2 py-1 text-xs font-medium rounded-full" 
                          :class="{
                              'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400': event.status === 'terjadwal',
                              'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400': event.status === 'berlangsung',
                              'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400': event.status === 'selesai'
                          }"
                          x-text="statusLabel(event.status)">
                    </span>
                </div>
            </template>
        </div>
    </div>

    <div x-show="selectedDateEvents.length === 0 && selectedDateText" class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700 text-center text-sm text-gray-500 dark:text-gray-400">
        Tidak ada kegiatan pada tanggal <span x-text="selectedDateText"></span>
    </div>
</div>

@push('scripts')
<script>
    function calendar() {
        return {
            currentMonth: new Date().getMonth(),
            currentYear: new Date().getFullYear(),
            selectedDate: null,
            selectedDateEvents: [],
            selectedDateText: '',
            events: {},
            days: [],
            months: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
            
            generateDays() {
                const firstDay = new Date(this.currentYear, this.currentMonth, 1).getDay();
                const daysInMonth = new Date(this.currentYear, this.currentMonth + 1, 0).getDate();
                const daysInPrevMonth = new Date(this.currentYear, this.currentMonth, 0).getDate();
                const newDays = [];
                
                // Previous month days
                for (let i = firstDay - 1; i >= 0; i--) {
                    const date = daysInPrevMonth - i;
                    const month = this.currentMonth - 1;
                    const year = month < 0 ? this.currentYear - 1 : this.currentYear;
                    const dateObj = new Date(year, (month + 12) % 12, date);
                    const dateString = dateObj.getFullYear() + '-' + String(dateObj.getMonth() + 1).padStart(2, '0') + '-' + String(dateObj.getDate()).padStart(2, '0');
                    newDays.push({
                        day: date,
                        dateStr: dateString,
                        isOtherMonth: true,
                        hasEvent: this.hasEvent(dateString),
                        isToday: false,
                        isSelected: this.isSelected(dateString),
                    });
                }
                
                // Current month days
                for (let i = 1; i <= daysInMonth; i++) {
                    const dateObj = new Date(this.currentYear, this.currentMonth, i);
                    const dateString = dateObj.getFullYear() + '-' + String(dateObj.getMonth() + 1).padStart(2, '0') + '-' + String(dateObj.getDate()).padStart(2, '0');
                    newDays.push({
                        day: i,
                        dateStr: dateString,
                        isOtherMonth: false,
                        hasEvent: this.hasEvent(dateString),
                        isToday: this.isToday(dateString),
                        isSelected: this.isSelected(dateString),
                    });
                }
                
                // Next month days
                const remaining = 42 - newDays.length;
                for (let i = 1; i <= remaining; i++) {
                    const dateObj = new Date(this.currentYear, this.currentMonth + 1, i);
                    const dateString = dateObj.getFullYear() + '-' + String(dateObj.getMonth() + 1).padStart(2, '0') + '-' + String(dateObj.getDate()).padStart(2, '0');
                    newDays.push({
                        day: i,
                        dateStr: dateString,
                        isOtherMonth: true,
                        hasEvent: this.hasEvent(dateString),
                        isToday: false,
                        isSelected: this.isSelected(dateString),
                    });
                }
                
                this.days = newDays;
            },
            
            initCalendar(month, year) {
                this.currentMonth = month - 1;
                this.currentYear = year;
                this.generateDays();
                this.fetchEvents();
            },
            
            fetchEvents() {
                const url = `{{ route('public.schedule.events') }}?month=${this.currentMonth + 1}&year=${this.currentYear}`;
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        this.events = data.events || {};
                        this.generateDays();
                    })
                    .catch(error => {
                        console.error('Error fetching events:', error);
                    });
            },
            
            hasEvent(dateStr) {
                return this.events[dateStr] && this.events[dateStr].length > 0;
            },
            
            isToday(dateStr) {
                const today = new Date();
                const todayStr = today.getFullYear() + '-' + String(today.getMonth() + 1).padStart(2, '0') + '-' + String(today.getDate()).padStart(2, '0');
                return dateStr === todayStr;
            },
            
            isSelected(dateStr) {
                if (!this.selectedDate) return false;
                return dateStr === this.selectedDate;
            },
            
            selectDate(day) {
                this.selectedDate = day.dateStr;
                
                const parts = day.dateStr.split('-');
                const dDate = parseInt(parts[2], 10);
                const dMonth = parseInt(parts[1], 10) - 1;
                const dYear = parseInt(parts[0], 10);
                
                this.selectedDateText = dDate + ' ' + this.months[dMonth] + ' ' + dYear;
                this.selectedDateEvents = this.events[day.dateStr] || [];
                this.generateDays();
            },
            
            formatDate(date) {
                return date.getDate() + ' ' + this.months[date.getMonth()] + ' ' + date.getFullYear();
            },
            
            statusLabel(status) {
                const labels = {
                    'terjadwal': 'Terjadwal',
                    'berlangsung': 'Berlangsung',
                    'selesai': 'Selesai',
                    'dibatalkan': 'Dibatalkan'
                };
                return labels[status] || status;
            },
            
            prevMonth() {
                this.currentMonth--;
                if (this.currentMonth < 0) {
                    this.currentMonth = 11;
                    this.currentYear--;
                }
                this.fetchEvents();
                this.selectedDate = null;
                this.selectedDateEvents = [];
                this.selectedDateText = '';
                this.generateDays();
            },
            
            nextMonth() {
                this.currentMonth++;
                if (this.currentMonth > 11) {
                    this.currentMonth = 0;
                    this.currentYear++;
                }
                this.fetchEvents();
                this.selectedDate = null;
                this.selectedDateEvents = [];
                this.selectedDateText = '';
                this.generateDays();
            },
            
            today() {
                const today = new Date();
                this.currentMonth = today.getMonth();
                this.currentYear = today.getFullYear();
                this.fetchEvents();
                
                const todayKey = today.getFullYear() + '-' + 
                               String(today.getMonth() + 1).padStart(2, '0') + '-' + 
                               String(today.getDate()).padStart(2, '0');
                this.selectedDate = todayKey;
                this.selectedDateEvents = this.events[todayKey] || [];
                this.selectedDateText = today.getDate() + ' ' + this.months[today.getMonth()] + ' ' + today.getFullYear();
                
                this.generateDays();
            }
        }
    }
</script>
@endpush