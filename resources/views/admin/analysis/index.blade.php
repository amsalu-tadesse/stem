<x-layout>
    <!-- Content Header (Page header) -->
    <x-breadcrump title="Analysis" parent="Analysis" child="List" />
    <div class="card">
    <div class="card-header">
    <div class="row">
        <div class="col-6">
        <form action="{{ route('admin.analysis') }}" method="GET">
        <input type="checkbox" id="checkbox1" name="allkpis" value="1" {{ $allkpis ? 'checked' : '' }} onchange="this.form.submit()">
                <label for="checkbox1">All Statuses</label>
            </form>
        </div>
        <div class="col-2 offset-4 float-right">
        <form action="{{ route('admin.analysis') }}" method="GET">
                <select id="levelselect2" name="level" class="form-control" onchange="this.form.submit()">
                    <option value="">All</option>
                    @foreach($levels as $level)
                    <option value="{{ $level->id }}" {{ $level->id == $selectLevel ? 'selected' : '' }}>{{ $level->name }}</option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>
</div>

        <div class="card-body">
            <div id="chartdiv">
            </div>
        </div>
    </div>

    @push('scripts')
    <!-- Styles -->
    <style>
        #chartdiv {
            width: 100%;
            height: 500px;
        }
    </style>

    <!-- Chart code -->
    <script>
        am5.ready(function() {

            // Create root element
            // https://www.amcharts.com/docs/v5/getting-started/#Root_element
            var root = am5.Root.new("chartdiv");

            // Set themes
            // https://www.amcharts.com/docs/v5/concepts/themes/
            root.setThemes([
                am5themes_Animated.new(root)
            ]);

            // Create chart
            // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/
            var chart = root.container.children.push(am5percent.PieChart.new(root, {
                radius: am5.percent(90),
                innerRadius: am5.percent(50),
                layout: root.horizontalLayout
            }));

            chart.responsive = true;

            // Create series
            // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Series
            var series = chart.series.push(am5percent.PieSeries.new(root, {
                name: "Series",
                valueField: "count",
                categoryField: "issue"
            }));

            // Set data
            // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Setting_data
            var data = @json($data);
            series.data.setAll(data
                // $data

                //    console.log(x);

                /* [{
                country: "Lithuania",
                sales: 501.9
            }, {
                country: "Czechia",
                sales: 301.9
            }, {
                country: "Ireland",
                sales: 201.1
            }, {
                country: "Germany",
                sales: 165.8
            }, {
                country: "Australia",
                sales: 139.9
            }, {
                country: "Austria",
                sales: 128.3
            }, {
                country: "UK",
                sales: 99
            }, {
                country: "Belgium",
                sales: 60
            }, {
                country: "The Netherlands",
                sales: 50
            }]*/


            );

            // Disabling labels and ticks
            series.labels.template.set("visible", false);
            series.ticks.template.set("visible", false);

            // Adding gradients
            series.slices.template.set("strokeOpacity", 0);
            series.slices.template.set("fillGradient", am5.RadialGradient.new(root, {
                stops: [{
                    brighten: -0.8
                }, {
                    brighten: -0.8
                }, {
                    brighten: -0.5
                }, {
                    brighten: 0
                }, {
                    brighten: -0.5
                }]
            }));

            // Create legend
            // https://www.amcharts.com/docs/v5/charts/percent-charts/legend-percent-series/
            var legend = chart.children.push(am5.Legend.new(root, {
                centerY: am5.percent(50),
                y: am5.percent(50),
                layout: root.verticalLayout
            }));
            // set value labels align to right
            legend.valueLabels.template.setAll({
                textAlign: "right"
            })
            // set width and max width of labels
            legend.labels.template.setAll({
                maxWidth: 140,
                width: 140,
                oversizedBehavior: "wrap"
            });

            legend.data.setAll(series.dataItems);


            // Play initial series animation
            // https://www.amcharts.com/docs/v5/concepts/animations/#Animation_of_series
            series.appear(1000, 100);

        }); // end am5.ready()
    </script>
    @endpush

</x-layout>
