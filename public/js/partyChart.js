new Morris.Donut({
    // ID of the element in which to draw the chart.
    element: 'party-chart',
    // Chart data records -- each entry in this array corresponds to a point on
    // the chart.
    data: [
        { label: 'Republicans', value: rep },
        { label: 'Democrats', value: dem }
    ],

    colors: [
        "#C86B6B", "#6B88C8"
    ]
});