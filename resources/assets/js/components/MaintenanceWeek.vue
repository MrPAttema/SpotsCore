<template>
    <div class="form-group">
        <label for="weekOne">Onderhoudsweek: (Kiezen voor het aanmaken van nieuw boekingsjaar)</label>
        <select class="" name="onderhoudweek">
            <option name="" value="0">Maak een keuze</option>
            @foreach ($occupied_weeks as $Week)
                <option name="" value="{{$Week->week}}">{{Week->week}}</option>
            @endforeach
        </select>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component ready.')
        }
    }
</script>
