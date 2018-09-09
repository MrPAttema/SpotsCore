<template>
    <div class="vue-element">
        <div class="column col-12 col-xs-12">
            <div class="form-group">
                <div class="">
                    <div class="form-group">
                        <label for="resWeekOne">Selecteer uw eerste week:</label>
                        <select name="weekOne" v-model="weekOne" @change="getPriceData()">
                            <option :value="week.week" v-for="week in weeks" :key="week.id">{{week.week}} {{week.type}}</option>
                        </select>
                    </div>
                    <div v-if="checked === false">
                        <div class="form-group" v-if="ronde1 === 1">
                            <label for="resWeekTwo">Selecteer uw tweede week:</label>
                            <select name="weekTwo" v-model="weekTwo" @change="getPriceDataTwo()">
                                <option :value="0">Geen voorkeur</option>
                                <option :value="week.week" v-for="week in weeks" :key="week.id">{{week.week}} {{week.type}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-12">
                        <label class="form-checkbox">
                            <input type="checkbox" name="two_weeks_together" @click="check($event)">
                            <i class="form-icon"></i> Reserveer twee weken achter elkaar.
                            <div class="popover popover-bottom">
                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                                <div class="popover-container">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-title h5">
                                                Weken samenvoegen.
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            Indien u deze optie aan vinkt maken wij van beide week één reservering.
                                            U kiest uw eerste week, wij plakken er daarna een aan vast.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
            <hr>
            <div class="card-body">
                Gegevens voor week: <b>{{ weekData.week }}</b>
                <br> 
                Incheckdatum: <b><span id="in">{{ weekData.enterDate }}</span></b>.
                <br>
                Uitcheckdatum: <b><span id="uit">{{ weekData.exitDate }}</span></b>.
                <br>
                Weekprijs: <b>&euro; <span>{{ weekData.price }}</span>,-</b>
            </div>
            <hr>
            <div class="card-body" v-if="ronde1 === 1">
                Gegevens voor week: <b>{{ weekDataTwo.week }}</b>
                <br> 
                Incheckdatum: <b><span id="in">{{ weekDataTwo.enterDate }}</span></b>.
                <br>
                Uitcheckdatum: <b><span id="uit">{{ weekDataTwo.exitDate }}</span></b>.
                <br>
                Weekprijs: <b>&euro; <span>{{ weekDataTwo.price }}</span>,-</b>
            </div>
            <hr>
            <div class="card-body" v-if="checked === true">
                Subtotaal: <b>&euro; <span name="subTotal">{{ subTotal }}</span></b>
                <br>
                Toeristenbelasting: <b>&euro; <span name="taxTotal">{{ taxTotal }}</span></b>
                <hr>
                Totaal: <b>&euro; <span name="totalprice">{{ totalPrice }}</span></b>
                <br>
                <hr>
            </div>
        </div>
    </div>
</template>

<script>

    const url = "/reservations/new/getprice";

    export default {
        props: {
            id: Number,
            res_year: Number,
            ronde1: Number,
            ronde2: Number,
            weeks: Array
        },
        data: function() {
            return {
                weekOne: "Maak een keuze",
                weekTwo: "Maak een keuze",
                loading: false,
                weekOnePrice: [],
                weekTwoPrice: [],
                checked: false,
                isReadOnly: false,
                weekData: [],
                weekDataTwo: [],
            }
        },
        methods: {
            getPriceData: function() {
                var self = this
                axios.post(url, {
                    week: self.weekOne,
                    location_id: self.id,
                    res_year: self.res_year
                })
                .then(function (response) {
                    self.weekData = response.data;
                    if (self.checked === true) {
                         self.twoWeeks();
                    } 
                })
                .catch(function (error) {
                    console.log(error);
                });       
            }, 
            getPriceDataTwo: function() {
                var self = this
                axios.post(url, {
                    week: self.weekTwo,
                    location_id: self.id,
                    res_year: self.res_year
                })
                .then(function (response) {
                    self.weekDataTwo = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });       
            }, 
            check: function(e) {
                if (e.target.checked) {
                    this.checked = true;
                    this.weekTwo.isReadOnly = true;
                    this.twoWeeks();
                } else if (!e.target.checked) {
                    this.checked = false;
                    this.weekTwo.isReadOnly = false;
                }
            },
            twoWeeks() {
                var self = this
                self.weekTwo = this.weekData.week + 1;
                axios.post(url, {
                    week: self.weekTwo,
                    location_id: self.id,
                    res_year: self.res_year
                })
                .then(function (response) {
                    self.weekDataTwo = response.data;
                    console.log(self.weekDataTwo);
                    
                })
                .catch(function (error) {
                    console.log(error);
                });       
            }
        },
        computed: {
            subTotal() {
                return (Number(this.weekData.price) + Number(this.weekDataTwo.price)).toFixed(2);
            },
            taxTotal() {
                return (Number(this.weekData.tax) + Number(this.weekDataTwo.tax)).toFixed(2);
            },
            totalPrice() {
                return (Number(this.subTotal) + Number(this.taxTotal)).toFixed(2);
            }
        }
    }
</script>
