<template>
    <BaseModal id="ReservationDetailsModal">
        <template v-slot:title>
            Reservation Details
        </template>
        <template v-slot:body>
            <p><strong>Start Time: </strong>{{selectedReservation.start}}</p>
            <p><strong>End Time: </strong>{{selectedReservation.end}}</p>
            <p><strong>Operator: </strong>
                {{selectedReservation.operatorFirstName}} {{selectedReservation.operatorLastName}}</p>
            <p><strong>Customer: </strong>
                {{selectedReservation.customerFirstName}} {{selectedReservation.customerLastName}}</p>
            <p><strong>Treatment: </strong>{{selectedReservation.treatment}}</p>
            <p><strong>Price: </strong>{{selectedReservation.price}}</p>
        </template>
        <template v-slot:footer>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <a :href="editReservationUrl" class="btn btn-warning">Edit</a>
            <button v-on:click="$emit('deleteClicked')" type="button" class="btn btn-danger">
                Delete
            </button>
        </template>
    </BaseModal>
</template>

<script>
  import BaseModal from './BaseModal'

  export default {
    name: "ReservationDetailsModal",
    components: {
      BaseModal
    },
    props: {
      selectedReservation: Object
    },
    computed: {
      editReservationUrl() {
        return '/staff/reservation/edit/' + this.selectedReservation.id
      },
    },
    methods: {
      show() {
        $('#ReservationDetailsModal').modal('show');
      },
      hide() {
        $('#ReservationDetailsModal').modal('hide');
      },
    },
  }
</script>
