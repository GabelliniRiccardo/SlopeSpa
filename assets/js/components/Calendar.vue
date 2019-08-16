<template>
    <div>
        <FlashMessage></FlashMessage>
        <CreateReservationModal v-bind:selectedEmptyDate="selectedEmptyDate"
                                v-bind:operatorDetailForEmptyDate="operatorDetailForEmptyDate">
        </CreateReservationModal>
        <ReservationDetailsModal v-on:deleteClicked="onDelete"
                                 v-bind:selectedReservation="selectedReservation">
        </ReservationDetailsModal>
        <ConfirmationModal v-on:deleteSuccess="onDeleteSuccess"
                           v-bind:selectedReservation="selectedReservation">
        </ConfirmationModal>
        <FullCalendar
                class='demo-app-calendar'
                ref="fullCalendar"
                :header="header"
                :plugins="calendarPlugins"
                :theme-system="themeSystem"
                :business-hours=businessHours
                :slot-label-format=slotLabelFormat
                :event-time-format=slotLabelFormat
                :defaultView="defaultView"
                :custom-buttons="customButtons"
                :all-day-slot=allDaySlot
                :time-zone=timezone
                :slot-width="slotWidth"
                :resource-area-width="resourceAreaWidth"
                :eventTextColor="eventTextColor"
                :now-indicator="nowIndicator"
                :resourceLabelText="resourceLabelText"
                :event-overlap="eventOverlap"
                :min-time=minTime
                :max-time=maxTime
                :events="calendarReservations"
                :height="height"
                :resources=resources
                @dateClick="handleEmptyDateClick"
                @eventClick="handleBusyDateClick"
                @eventMouseEnter="onDateHover"
        />
    </div>
</template>

<script>
  import FullCalendar from '@fullcalendar/vue'
  import CreateReservationModal from './modals/CreateReservationModal'
  import ReservationDetailsModal from './modals/ReservationDetailsModal'
  import ConfirmationModal from './modals/ConfirmationModal'
  import Tooltip from '../services/Tooltip'
  import {operatorsClient} from "../services/http/OperatorsClient"
  import {reservationsClient} from "../services/http/ReservationsClient"
  import 'bootstrap';

  export default {
    components: {
      CreateReservationModal,
      ReservationDetailsModal,
      ConfirmationModal,
      FullCalendar // make the <FullCalendar> tag available
    },
    props: {
      calendarPlugins: Array,
      defaultView: String,
      currentDate: Date
    },
    data() {
      return {
        themeSystem: 'bootstrap',
        businessHours: {
          daysOfWeek: [1, 2, 3, 4, 5, 6, 7, 0], // days of week. an array of zero-based day of week integers (0=Sunday)
          startTime: '8:00',
          endTime: '20:00',
        },
        slotLabelFormat: {
          hour: '2-digit',
          minute: '2-digit',
          hour12: false,
          omitZeroMinute: false,
          meridiem: 'short'
        },
        header: {
          left: 'prev, today, next',
          center: 'title',
          right: 'previousMonth, nextMonth',
        },
        customButtons: {
          nextMonth: {
            text: 'Next Month',
            click: () => {
              const calendarApi = this.$refs.fullCalendar.getApi();
              const date = calendarApi.getDate();
              const newDate = new Date(date.setMonth(date.getMonth() + 1));
              calendarApi.gotoDate(newDate);
            },
          },
          previousMonth: {
            text: 'Previous Month',
            click: () => {
              const calendarApi = this.$refs.fullCalendar.getApi();
              const date = calendarApi.getDate();
              const newDate = new Date(date.setMonth(date.getMonth() + -1));
              calendarApi.gotoDate(newDate);
            }
          }
        },
        allDaySlot: false,
        timezone: 'local',
        slotWidth: 70,
        resourceAreaWidth: 200,
        eventTextColor: 'gray',
        nowIndicator: true,
        resourceLabelText: 'Operators',
        eventOverlap: false,
        minTime: '8:00',
        maxTime: '20:00',
        height: 640,
        resources: [],
        calendarReservations: [], // initial event data
        selectedEmptyDate: null,
        selectedReservation: {
          treatment: null,
          start: null,
          end: null,
          customerFirstName: null,
          customerLastName: null,
          operatorFirstName: null,
          operatorLastName: null,
          id: null,
          price: null
        },
        operatorDetailForEmptyDate: {
          title: '',
          id: null
        },
      }
    },
    methods:
      {
        handleEmptyDateClick(info) {
          console.log('clicked on empty date');
          this.operatorDetailForEmptyDate = info.resource._resource;
          this.selectedEmptyDate = new Date(info.date);
          CreateReservationModal.methods.show();
        }
        ,
        handleBusyDateClick(info) {
          console.log('clicked on busy date');
          let details = info.event._def.extendedProps;
          this.selectedReservation = {
            treatment: info.event.title,
            start: info.event.start,
            end: info.event.end,
            customerFirstName: details.customerFirstName,
            customerLastName: details.customerLastName,
            operatorFirstName: details.operatorFirstName,
            operatorLastName: details.operatorLastName,
            id: details.reservationId,
            price: details.price
          };
          ReservationDetailsModal.methods.show();
        }
        ,
        loadDayData(date) {
          return reservationsClient.getCalendarReservations(date);
        }
        ,
        loadOperators() {
          return operatorsClient.getOperators();
        }
        ,
        onDateHover(info) {
          new Tooltip().setInfo(info);
        }
        ,
        onDelete() {
          ReservationDetailsModal.methods.hide();
          ConfirmationModal.methods.show();
        }
        ,
        onDeleteSuccess(reservationId) {
          this.calendarReservations = this.calendarReservations.filter(reservation => reservation.reservationId !== reservationId
          );
        },
        getCurrentDate() {
          const calendarApi = this.$refs.fullCalendar.getApi();
          const date = calendarApi.getDate();
          return date;
        }
      }
    ,
    created() {
      this.resources = this.loadOperators();
      this.calendarReservations = this.loadDayData(new Date())
    },
    mounted() {
      const calendarApi = this.$refs.fullCalendar.getApi();
      calendarApi.gotoDate(this.currentDate);
    }
  }

</script>
