<template>
    <BaseModal id="CreateReservationModal">
        <template v-slot:title>
            Create Reservation
        </template>
        <template v-slot:body>
            <p>Do you want to create a reservation on:</p>
            <p><strong>Start Time: </strong>{{selectedEmptyDate}}</p>
            <p><strong>Operator: </strong>{{operatorDetailForEmptyDate.title}}</p>
        </template>
        <template v-slot:footer>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <a :href="createReservationUrl" class="btn btn-primary">Yes</a>
        </template>
    </BaseModal>
</template>

<script>
  import BaseModal from './BaseModal'

  export default {
    name: "CreateReservationModal",
    components: {
      BaseModal
    },
    props: {
      selectedEmptyDate: Date,
      operatorDetailForEmptyDate: {
        title: '',
        id: null
      }
    },
    computed: {
      createReservationUrl() {
        if (this.selectedEmptyDate) {
          return '/staff/reservation/create/?date=' + this.formatDate(this.selectedEmptyDate) + '&operatorId=' + this.operatorDetailForEmptyDate.id
        }
        return;
      },
    },
    methods: {
      show() {
        $('#CreateReservationModal').modal('show');
      },
      formatDate(myDate) {
        let date = myDate.toLocaleString().split(',')[0].split('/');
        let time = myDate.toLocaleString().split(',')[1];
        return date[2] + '/' + date[1] + '/' + date[0] + ' ' + time;
      }
    }
  }
</script>
