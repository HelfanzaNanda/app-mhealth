@extends('backoffice.layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div id="home-page">
  <div class="row">
    <div class="col-md-3">
      <div class="card " >
        <div class="card-body">
          <label class="mb-0">Database</label>
          <h3 class="mb-1">@{{homeData.contact_count}}</h3>
          <div class="text-right"><a href="{{url('contact')}}">Lihat <i style="width: 17px;height: 17px;" data-feather="arrow-right"></i></a></div>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card text-white bg-warning" >
        <div class="card-body">
          <label class="mb-0">Antrian Pesan</label>
          <h3 class="mb-1">@{{homeData.queue_count}}</h3>
          <div class="text-right"><a href="{{url('queue')}}" class="text-white">Lihat <i style="width: 17px;height: 17px;" data-feather="arrow-right"></i></a></div>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card text-white bg-success" >
        <div class="card-body">
          <label class="mb-0">Whatsapp Status</label>
          <h3 class="mb-1">@{{homeData.wa_status}}</h3>
          <div class="text-right"><a onclick="$('#qr-code-modal').modal('show')" href="javascript:;" class="text-white">Hubungkan <i style="width: 17px;height: 17px;" data-feather="arrow-right"></i></a></div>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card text-white bg-info">
        <div class="card-body">
          <label class="mb-0">Lisensi valid</label>
          <h3 class="mb-1">30-12-2099</h3>
          <div class="text-right"><a onclick="$('#qr-code-modal').modal('show')" href="javascript:;" class="text-white">Perpanjang <i style="width: 17px;height: 17px;" data-feather="arrow-right"></i></a></div>
        </div>
      </div>
    </div>
  </div>
  
</div>
@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/chartjs/Chart.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/jquery.flot/jquery.flot.js') }}"></script>
  <script src="{{ asset('assets/plugins/jquery.flot/jquery.flot.resize.js') }}"></script>
  <script src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/apexcharts/apexcharts.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/vue-apexcharts/vue-apexcharts.js') }}"></script>
  <script src="{{ asset('assets/plugins/progressbar-js/progressbar.min.js') }}"></script>
@endpush

@push('scripts')
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
  <script src="{{ asset('assets/js/datepicker.js') }}"></script>
  <script type="text/javascript">

    Vue.use(VueApexCharts);
    Vue.component('apexchart', VueApexCharts)
    var home = new Vue({
      el:'#home-page',
      data:{
        homeData:{},
        charts:{
          averageOrder:{
            series: [{
                name: "Current weeks",
                data: [10, 41, 35, 51, 49, 62, 69]
            },{
                name: "Last weeks",
                data: [100, 41, 35, 51, 49, 62, 69]
            }],
              chart: {
              height: 200,
              type: 'line',
              zoom: {
                enabled: false
              }
            },
            dataLabels: {
              enabled: false
            },
            stroke: {
              curve: 'straight',
              width:1
            },
            xaxis: {
              categories: ['Sun', 'Mon', 'Tue', 'Wed', 'Fri', 'Sat'],
            }
          },
          websiteTraffict:{
            chart: {
              height: 300,
              type: "pie"
            },
            colors: ["#f77eb9", "#7ee5e5","#4d8af0","#fbbc06"],
            legend: {
              position: 'left',
              horizontalAlign: 'center'
            },
            theme: {
              monochrome: {
                enabled: true
              }
            },
            plotOptions: {
              pie: {
                dataLabels: {
                  offset: -10
                }
              }
            },
            dataLabels: {
              formatter(val, opts) {
                const name = opts.w.globals.labels[opts.seriesIndex]
                return [name, val.toFixed(1) + '%']
              }
            },
            labels: ['Direct','Search Engine','Social Media','Others'],
            series: [44, 55, 13, 33]
          },
          websiteTraffictDevice:{
            series: [
              {
                name: 'Mobile',
                data: [44, 55, 41, 37, 22, 43]
              }, {
                name: 'Desktop',
                data: [53, 32, 33, 52, 13, 43]
              }
            ], 
            chart: {
              type: 'bar',
              height: 350,
              stacked: true,
              stackType: '100%'
            },
            plotOptions: {
              bar: {
                horizontal: true,
              },
            },
            stroke: {
              width: 0,
              colors: ['#fff']
            },
            xaxis: {
              categories: ['Direct','Search Engine','Social Media','Others'],
            },
            tooltip: {
              y: {
                formatter: function (val) {
                  return val + "%"
                }
              }
            },
            legend: {
              position: 'top',
              horizontalAlign: 'left',
              offsetX: 40
            }
        }
        }
      },
      updated(){
        // generateChart()
      },
      mounted(){
        this.get_data();
        setInterval(()=>{
          this.get_data();
        },10000)
        // generateChart()
      },
      methods:{
        async get_data(){
          await eiApi.post('admin/home').then(response=>{
            this.homeData = response.data.result;
            // this.chart.averageOrder.series=this.homeData.averageOrder.series;
            // this.chart.averageOrder.xaxis.categories=this.homeData.averageOrder.categories;

            // this.charts.websiteTraffict.series=this.homeData.websiteTraffict.series;
            // this.charts.websiteTraffict.labels=this.homeData.websiteTraffict.labels;
            // console.log(this.charts.websiteTraffictDevice.xaxis.categories);
            // this.charts.websiteTraffictDevice.series=this.homeData.websiteTraffictDevice.series;
            // this.charts.websiteTraffictDevice.xaxis=this.homeData.websiteTraffictDevice.xaxis;
            // this.charts.orderByYear.series = this.homeData.orderByYear.series;
          })
        }
      }
    })
  </script>
@endpush