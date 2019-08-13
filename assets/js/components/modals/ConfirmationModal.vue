<template>
    <BaseModal id="ConfirmationModal">
        <template v-slot:title>
            Confirmation
        </template>
        <template v-slot:body>
            <div v-if="!loading">
                Are you sure?
            </div>
            <div class="text-center" v-else>
                <div class="spinner-grow text-primary" role="status"></div>
                <div class="spinner-grow text-secondary" role="status"></div>
                <div class="spinner-grow text-success" role="status"></div>
                <div class="spinner-grow text-danger" role="status"></div>
                <div class="spinner-grow text-warning" role="status"></div>
                <div class="spinner-grow text-info" role="status"></div>
            </div>
        </template>
        <template v-slot:footer>
            <div v-if="!loading">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button v-on:click="deleteReservation" type="button" class="btn btn-primary">Yes</button>
            </div>
        </template>
    </BaseModal>
</template>

<script>
  import BaseModal from './BaseModal'
  import {reservationsClient} from '../../services/http/ReservationsClient'

  export default {
    name: "ConfirmationModal",
    components: {
      BaseModal
    },
    data() {
      return {
        loading: false
      }
    },
    props: {
      selectedReservation: Object
    },
    methods: {
      show() {
        $('#ConfirmationModal').modal('show');
      },
      hide() {
        $('#ConfirmationModal').modal('hide');
      },
      deleteReservation() {
        this.loading = true;
        reservationsClient.deleteReservation(
          this.selectedReservation.id,
          (responseMessage) => {
            console.error('error');
            this.hide();
            this.flashMessage.show({
              status: 'error',
              title: 'Error',
              message: responseMessage,
            })
          },
          (responseMessage) => {
            this.hide();
            setTimeout(() => {
              this.loading = false;
            }, 500);
            this.flashMessage.show({
              status: 'success',
              title: 'Success',
              message: responseMessage,
            });
            this.$emit('deleteSuccess', this.selectedReservation.id);
          });
      }
    }
  }
</script>
