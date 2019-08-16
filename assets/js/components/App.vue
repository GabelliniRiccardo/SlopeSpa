<template>
    <div>
        <div v-if="isVertical">
            <Calendar
                    ref="verticalCalendar"
                    key="vertical"
                    v-bind:calendar-plugins="VerticalCalendar.calendarPlugins"
                    v-bind:default-view="VerticalCalendar.defaultView"
                    v-bind:currentDate="currentDate">
            </Calendar>
        </div>
        <div v-else>
            <Calendar
                    ref="horizontalCalendar"
                    key="horizontal"
                      v-bind:calendar-plugins="HorizontalCalendar.calendarPlugins"
                      v-bind:default-view="HorizontalCalendar.defaultView"
                      v-bind:currentDate="currentDate">
            </Calendar>
        </div>
        <div class="row">
            <div class="col text-center mt-4">
                <toggle-button
                        @change="onSwitchClick"
                        :value="isVertical"
                        :color="{checked: 'rgba(0,150,0,0.33)', unchecked: 'rgba(0,117,255,0.48)', disabled: '#CCCCCC'}"
                        :sync="true"
                        :labels="{checked: 'Vertical View', unchecked: 'Horizontal View'}"
                        :width="150"
                        :height="35"
                        :font-size="10"/>
            </div>
        </div>
    </div>
</template>

<script>
  import Calendar from './Calendar'
  import interactionPlugin from '@fullcalendar/interaction'
  import resourceTimeGridPlugin from '@fullcalendar/resource-timegrid';
  import resourceTimelinePlugin from '@fullcalendar/resource-timeline'
  import bootstrapPlugin from '@fullcalendar/bootstrap';

  export default {
    name: "App",
    data() {
      return {
        isVertical: true,
        VerticalCalendar: {
          calendarPlugins: [
            resourceTimeGridPlugin,
            interactionPlugin, // needed for dateClick
            bootstrapPlugin
          ],
          defaultView: 'resourceTimeGridDay',
        },
        HorizontalCalendar: {
          calendarPlugins: [
            resourceTimelinePlugin,
            interactionPlugin, // needed for dateClick
            bootstrapPlugin
          ],
          defaultView: 'resourceTimelineDay',
        },
        currentDate: new Date()
      }
    },
    components: {
      Calendar
    },
    methods: {
      onSwitchClick() {
        console.log('switch clicked!');
        if(this.isVertical){
          this.currentDate = this.$refs.verticalCalendar.getCurrentDate();
        }
        else{
          this.currentDate = this.$refs.horizontalCalendar.getCurrentDate();
        }
        this.isVertical = !this.isVertical;
      }
    }
  }
</script>
