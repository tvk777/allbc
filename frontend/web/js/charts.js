window.onload = function() {
  if($(".chart").length) {

    function chart(data) {
      let arc = d3.arc().cornerRadius(10).startAngle(0);
      let svg = d3.select('.chart');
      let size = Math.PI*3/2;
      arcs(true);
      arcs(false);
      svg.selectAll('text').data(data).enter().append('text')
         .text( function(d) {
            return d.text;
         })
         .style('font-size', 10)
         .style('text-anchor', 'end')
         .style('font-family', 'arial')
         .attr('x', -10)
         .attr('y', function(d){
          return d.index*14-65;
         })

      function arcs(isBg) {
        let selection = svg.selectAll('path.'+ (isBg ? 'bg' : 'arc'))
        selection = selection.data(data).enter().append('path').merge(selection);
        selection.classed(isBg ? 'bg' : 'arc', true)
          .attr('fill', function(d) {
            return isBg ? '#ccc' : d.color;
          })
          .attr('d', function(d){
            return arc({
              innerRadius: 20 + d.index*15 + (d.index?0:3),
              outerRadius: 20 + d.index*15 + 8,
              endAngle: isBg ? size : d.value*size/100
            });
          });
      }

    }

    chart([ 
      [20, '#0578e9', "142 000 м²"], 
      [40, '#f278bb', "82 000 м²"], 
      [60, '#f9b349', "60 000 м²"], 
      [80, '#3eb060', "20 000 м²"]
    ].map(function (d, i) {
      return {
        index: i, 
        color: d[1],
        value: d[0],
        text: d[2]
      }
    }));

  }
}