@extends('layouts.layout')
@section('content')
    <div style="padding: 80px;">

        <div class="d-flex justify-content-center mb-4">
            @include('components.create')
        </div>

        <div id="calendar">

        </div>
    </div>

    <script>
        function formatDate(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0'); // Adding 1 because months are zero-indexed
            const day = String(date.getDate()).padStart(2, '0');
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');
            const seconds = String(date.getSeconds()).padStart(2, '0');

            // return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
            return {
                day: `${year}-${month}-${day}`,
                time: `${hours}:${minutes}:${seconds}`
            }
        }

        function create(start, end) {
            let modalOpen = document.getElementById('modalOpen')
            let dayI = document.getElementById('day')
            let startI = document.getElementById('start')
            let endI = document.getElementById('end')

            // console.log(start, end)

            dayI.value = start.day
            startI.value = start.time
            endI.value = end.time

            modalOpen.click()
        }

        document.addEventListener('DOMContentLoaded', async function() {
            var calendarEl = document.getElementById('calendar');

            if (calendarEl == null) return;

            const {
                data
            } = await axios.get(
                '/reservations'); 

            const reservations = data.reservations

            // console.log(reservations) // Professionals debugging brrrr

            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                initialView: 'timeGridWeek',
                // weekends: false,
                slotMinTime: "08:00:00",
                slotMaxTime: "18:00:00",
                nowIndicator: true,
                events: reservations,
                height: '80vh',
                expandRows: true,
                selectable: true,
                selectMirror: true,
                selectOverlap: false,
                eventClick: (info) => {
                    window.location.href = `/reservations/${info.event.id}`
                },
                select: (info) => {
                    let start = info.start;
                    let end = info.end;

                    if ((end.getDate() - start.getDate()) > 1) {
                        alert('You may only make a reservation in one day!!')
                        calendar.unselect()
                        return;
                    }

                    if (info.allDay) {
                        create({
                            day: formatDate(start).day,
                            time: '08:00:00'
                        }, {
                            day: formatDate(start).day,
                            time: '18:00:00'
                        })
                    } else {
                        if (formatDate(start).day != formatDate(end).day) {
                            alert('You may only make a reservation in one day!!')
                            calendar.unselect()
                            return;
                        }
                        create(formatDate(start), formatDate(end))
                    }

                },
                selectAllow: (info) => {
                    let today = new Date();
                    return (info.start < today) ? false : true
                }
            });
            calendar.render();
        });
    </script>
@endsection
