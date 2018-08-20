<template>
    <div class="vue-element">
        <div class="column col-12 col-xs-12">
            <div class="form-group">
                <div class="">
                    <div class="form-group">
                        <label for="resWeekOne">Selecteer uw eerste week:</label>
                        <select name="res_week1" v-model="weekOnePrice">
                            <option :value="{week: week.week, price: week.price, in: week.enterDate, uit: week.exitDate, tax: week.tax}" v-for="week in weeks" :key="week.id">{{week.week}}</option>
                        </select>
                    </div>
                    <div v-if="checked === false">
                        <div class="form-group" v-if="ronde1 === 1">
                            <label for="resWeekOne">Selecteer uw tweede week:</label>
                            <select name="res_week2" v-model="weekTwoPrice" :disabled="isReadOnly">
                                <option :value="{week: 'Geen voorkeur', price: 0, in: 'Geen voorkeur', uit: 'Geen voorkeur', tax: 0}">Geen voorkeur</option>
                                <option :value="{week: week.week, price: week.price, in: week.enterDate, uit: week.exitDate, tax: week.tax}" v-for="week in weeks" :key="week.id">{{week.week}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-12">
                        <label class="form-checkbox">
                            <input type="checkbox" id="two_weeks_together" @click="check($event)">
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
                                            Indien u deze optie aan vinkt maken wij van beide week en reservering.
                                            Dit betekend wel dat u weken moet kiezen die elkaar opvolgen.
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
                Gegevens voor week: <b>{{ weekOnePrice.week }}</b>
                <br> 
                Incheckdatum: <b><span id="in">{{ weekOnePrice.in }}</span></b>.
                <br>
                Uitcheckdatum: <b><span id="uit">{{ weekOnePrice.uit }}</span></b>.
                <br>
                Weekprijs: <b>&euro; <span>{{ weekOnePrice.price }}</span>,-</b>
            </div>
            <hr>
            <div class="card-body" v-if="ronde1 === 1">
                Gegevens voor week: <b>{{ weekTwoPrice.week }}</b>
                <br> 
                Incheckdatum: <b><span id="in">{{ weekTwoPrice.in }}</span></b>.
                <br>
                Uitcheckdatum: <b><span id="uit">{{ weekTwoPrice.uit }}</span></b>.
                <br>
                Weekprijs: <b>&euro; <span>{{ weekTwoPrice.price }}</span>,-</b>
            </div>
            <hr>
            <div class="card-body" v-if="checked === false">
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
    export default {
        props: {
            id: Number,
            tax: Number,
            taxtype: Number,
            ronde1: Number,
            ronde2: Number,
            weeks: Array,
            week: {
                id: Number,
                location_id: Number,
                price: Number,
                week: Number,
                bezet: Number,
                enterDate: String,
                exitDate: String,
            }
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
            }
        },
        methods: {
            check: function(e) {
                if (e.target.checked) {
                    this.checked = true;
                    this.isReadOnly = true;
                    this.twoWeeks();
                } else if (!e.target.checked) {
                    this.checked = false;
                    this.isReadOnly = false;
                }
            },
            twoWeeks() {
                this.weekTwoPrice.week = this.weekOnePrice.week + 1;
            }
        },
        computed: {
            subTotal() {
                return (Number(this.weekOnePrice.price) + Number(this.weekTwoPrice.price)).toFixed(2);
            },
            taxTotal() {
                return (Number(this.weekOnePrice.tax) + Number(this.weekTwoPrice.tax)).toFixed(2);
            },
            totalPrice() {
                return (Number(this.subTotal) + Number(this.taxTotal)).toFixed(2);
            }
        }
    }
</script>
