<template>
    <div class="vue-element">
        <div class="column col-12 col-xs-12">
            <div class="form-group">
                <div class="slide-upper">
                    <div class="form-group">
                        <label for="resWeekOne">Selecteer uw voorkeursweek:</label>
                        <select v-bind="resWeekOne" v-on:change="getPrice" required="" class="" name="resWeekOne">
                            <option selected hidden value="">Maak een keuze</option>
                            <option name="" value='32'>32</option>
                        </select>
                    </div>
                </div>
            </div>
            <hr>
            <div class="card-body">
                Prijs voor week: <b><span>{{ weekOne }}</span></b>
                <br>
                <b>&euro; <span>{{ price }}</span>,-</b> per week
                <div class="location-toerist-tax">
                    Incl toeristenbelasting: &euro; p.p.p.n.
                </div>
            </div>
            <hr>
            <div class="card-body">
                <img  v-if="loading" src="/img/mini_load.svg" alt="">
                <br>
                Prijs voor week: <b><span>{{ weekTwo }}</span></b>
                <br>
                <b>&euro; <span>{{ priceTwo }}</span>,-</b> per week
                <div class="location-toerist-tax">
                    Incl toeristenbelasting: &euro; p.p.p.n.
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    const url = "/price/week";
    var self = this;

    export default {
        mounted() {
            console.log('Component ready.')
            this.loading = false;
        },
        created() {
            this.getPrice()
        },
        data: function() {
            return {
                weekOne: "Maak een keuze",
                weekTwo: "Maak een keuze",
                price: "..",
                priceTwo: "..",
                loading: false,
                resWeekOne: ''
            }
        },
        methods: {
            getPrice() {
                self.loading = true;
                axios({
                    method:'post',
                    url: url,
                    data: {
                        weekOne: resWeekOne,
                        weekTwo: weekTwo
                    }
                })
                .then(function(response){
                    self.loading = false;
                    console.log(response.data)
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
        }
    }
</script>
