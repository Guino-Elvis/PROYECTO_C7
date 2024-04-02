@section('title', 'Dahsboard - General')
@section('header', 'Dahsboard')
@section('section', 'General')

<div>
    <div class="grid sm:grid-cols-2 sm:gap-x-4 md:grid-cols-3 lg:md:grid-cols-4 xl:grid-cols-5">
        <a href="#" class="group">
            <x-card class="pt-0 px-0 hover:border-indigo-600 hover:scale-[1.02] duration-200">
                <x-dashboard-content-card>
                    <x-slot name="title">Categorias</x-slot>
                    <x-slot name="amount">4</x-slot>
                    <i class="fa-solid fa-tag text-6xl"></i>
                </x-dashboard-content-card>
            </x-card>
        </a>
        <a href="#" class="group">
            <x-card class="pt-0 px-0 hover:border-indigo-600 hover:scale-[1.02] duration-200">
                <x-dashboard-content-card>
                    <x-slot name="title">Sub-Categorias</x-slot>
                    <x-slot name="amount">15</x-slot>
                    <i class="fa-solid fa-tags text-6xl"></i>
                </x-dashboard-content-card>
            </x-card>
        </a>
        <a href="#" class="group">
            <x-card class="pt-0 px-0 hover:border-indigo-600 hover:scale-[1.02] duration-200">
                <x-dashboard-content-card>
                    <x-slot name="title">Productos</x-slot>
                    <x-slot name="amount">162</x-slot>
                    <i class="fa-solid fa-cart-flatbed-suitcase text-6xl"></i>
                </x-dashboard-content-card>
            </x-card>
        </a>
        <a href="#" class="group">
            <x-card class="pt-0 px-0 hover:border-indigo-600 hover:scale-[1.02] duration-200">
                <x-dashboard-content-card>
                    <x-slot name="title">Banners</x-slot>
                    <x-slot name="amount">15</x-slot>
                    <i class="fa-solid fa-images text-6xl"></i>
                </x-dashboard-content-card>
            </x-card>
        </a>
        <a href="#" class="group">
            <x-card class="pt-0 px-0 hover:border-indigo-600 hover:scale-[1.02] duration-200">
                <x-dashboard-content-card>
                    <x-slot name="title">Usuarios</x-slot>
                    <x-slot name="amount">1</x-slot>
                    <i class="fa-solid fa-users text-6xl"></i>
                </x-dashboard-content-card>
            </x-card>
        </a>
    </div>

    <div class="grid sm:grid-cols-2 sm:gap-x-4 md:grid-cols-3 lg:md:grid-cols-4 xl:grid-cols-5">
        <x-card col="3">
            <div class="text-sm text-center">
                <div class="pb-3 border-b border-gray-300">
                    Somos innovadores por excelencia
                </div>
                <div class="py-2">
                    <h5 class="text-indigo-600 text-base font-medium mb-2 ">¡Bienvenido al sistema!</h5>
                    <p class="text-gray-700">
                        {{ Auth::user()->name }} -
                        {{ Auth::user()->email }}
                    </p>
                </div>
                <div class="pt-3 border-t border-gray-300 text-gray-600 items-center">
                    <div id="fecha"></div>
                    <div id="tiempo"></div>
                </div>
            </div>
        </x-card>
        <x-card col="2">

            <h3 class="text-xl font-bold leading-none text-gray-900 me-1">Gráfico</h3>
            <!-- Line Chart -->
            <div class="pt-2" id="pie-chart"></div>
        </x-card>

        <div class="scale-75 translate-x-4 skew-y-3 md:transform-none">
            <x-card></x-card>
            <div x-data="accordion(1)"
                class="relative transition-all duration-700 border rounded-xl hover:shadow-2xl">
                <div @click="handleClick()" class="w-full p-4 text-left cursor-pointer">
                    <div class="flex items-center justify-between">
                        <span class="tracking-wide">What is x-data ?</span>
                        <span :class="handleRotate()" class="transition-transform duration-500 transform fill-current ">
                            <svg class="w-5 h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                            </svg>
                        </span>
                    </div>
                </div>

                <div x-ref="tab" :style="handleToggle()"
                    class="relative overflow-hidden transition-all duration-500 max-h-0">
                    <div class="px-6 pb-4 text-gray-600">
                        Declare a new Alpine component and its data for a block of HTML </div>
                </div>
            </div>
            <script>
                // Faq
                document.addEventListener("alpine:init", () => {
                    Alpine.store("accordion", {
                        tab: 0
                    });

                    Alpine.data("accordion", (idx) => ({
                        init() {
                            this.idx = idx;
                        },
                        idx: -1,
                        handleClick() {
                            this.$store.accordion.tab =
                                this.$store.accordion.tab === this.idx ? 0 : this.idx;
                        },
                        handleRotate() {
                            return this.$store.accordion.tab === this.idx ? "-rotate-180" : "";
                        },
                        handleToggle() {
                            return this.$store.accordion.tab === this.idx ?
                                `max-height: ${this.$refs.tab.scrollHeight}px` :
                                "";
                        }
                    }));
                });
                //  end faq
            </script>
        </div>
    </div>
</div>

@section('page-script')
    <script>
        const getChartOptions = () => {
            return {
                series: [4, 15, 40, 4, 1],
                colors: ["#1C64F2", "#16BDCA", "#f59e0b", "#9061F9", "#65a30d"],
                chart: {
                    height: 420,
                    width: "100%",
                    type: "pie",
                },
                stroke: {
                    colors: ["white"],
                    lineCap: "",
                },
                plotOptions: {
                    pie: {
                        labels: {
                            show: true,
                        },
                        size: "100%",
                        dataLabels: {
                            offset: -25
                        }
                    },
                },
                labels: ["Categorias", "Sub-Categorias", "Productos", "Banners", "Usuarios"],
                dataLabels: {
                    enabled: true,
                    style: {
                        fontFamily: "Inter, sans-serif",
                    },
                },
                legend: {
                    position: "bottom",
                    fontFamily: "Inter, sans-serif",
                },
                yaxis: {
                    labels: {
                        formatter: function(value) {
                            return value + ""
                        },
                    },
                },
                xaxis: {
                    labels: {
                        formatter: function(value) {
                            return value + ""
                        },
                    },
                    axisTicks: {
                        show: false,
                    },
                    axisBorder: {
                        show: false,
                    },
                },
            }
        }

        if (document.getElementById("pie-chart") && typeof ApexCharts !== 'undefined') {
            const chart = new ApexCharts(document.getElementById("pie-chart"), getChartOptions());
            chart.render();
        }
    </script>

    <script>
        setInterval(function() {
            var fechaActual = new Date();
            var dia = new Intl.DateTimeFormat("es", {
                weekday: "long"
            }).format(fechaActual);
            var mes = new Intl.DateTimeFormat("es", {
                month: "long"
            }).format(fechaActual);
            var anio = fechaActual.getFullYear();
            document.getElementById("fecha").innerHTML = dia + " " + fechaActual.getDate() + " de " + mes + " de " +
                anio;
        }, 1000);
    </script>
@endsection
