/**
 * Created by adil on 8/1/16.
 */

Vue.config.dbeug = true;

Vue.component('dropbox-sync-component', {
    template: '#dropbox-sync-component',
    data : function () {
        return {
            data : {
                rejected_files: {},
                pending_files: {},
                processing_files: {},
                recent_files : {}
            },
            loading: true,
            ajax : false,
            error: false,
            errorMsg : '',
            page : '',
            rPage : '',
            pPage : '',
            prPage : '',
            rePage : ''
        }
    },
    ready: function () {

        this.loading = true;
        this.start();
        setInterval(function () {
            for (var i = 0; i < vm.$children.length; i++) {
                if (vm.$children[i].$options.name == "dropbox-sync-component") {
                    vm.$children[i].start();
                }
            }
        }, 300000);
    },
    methods: {
        start : function () {

            this.ajax = true;

            var page;

            if (this.page) {
                page = '?'+this.namespace+'_page=' + this.page;
            }else {
                page = '';
            }


            this.$http.get(
                APP_URL + '/dropbox-widget' + page, { 'namespace' : this.namespace , 'rPage' : this.rPage, 'pPage' : this.pPage, 'prPage' : this.prPage, 'rePage' : this.rePage }
            ).then(function (successResponse) {
                 this.$data.data = successResponse.data;
                 var filesData = [
                    {
                        "status": "Pending Files",
                        "icon": "<i class='status-mark border-blue-300 position-left'></i>",
                        "value": this.data.pending,
                        "color": "#29B6F6"
                    },
                    {
                        "status": "Rejected Files",
                        "icon": "<i class='status-mark border-danger-300 position-left'></i>",
                        "value": this.data.rejected,
                        "color": "#EF5350"
                    },
                    {
                        "status": "Processed Files",
                        "icon": "<i class='status-mark border-success-300 position-left'></i>",
                        "value": this.data.processed,
                        "color": "#66BB6A"
                    },
                    {
                        "status": "Processing Files",
                        "icon": "<i class='status-mark border-grey-300 position-left'></i>",
                        "value": this.data.processing,
                        "color": "#888"
                    }
                ];
                // Initialize chart
                $("#tickets-status").html('');
                ticketStatusDonut("#tickets-status", 42, filesData);

                this.loading = false;
                this.ajax = false;
                this.error = false;

            }, function (errorResponse) {
                this.error = true;
                this.errorMsg = errorResponse.status + ' ' + errorResponse.statusText;

            });
        },
        push: function () {
            swal({
                    title: "Are you sure?",
                    text: "Process will be start from scratch, Only the new files will sync!",
                    type: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, Re-Sync it!",
                    cancelButtonText: "No, cancel please!",
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function(isConfirm){
                    if (isConfirm) {
                        for (var i = 0; i < vm.$children.length; i++) {
                            if (vm.$children[i].$options.name == "dropbox-sync-component") {
                                vm.$children[i].sync();
                            }
                        }
                    }
                });
        },
        sync : function () {
            this.ajax = true;
            this.$http.get(APP_URL+'/dropbox-sync-images').then(
                function (successResponse) {
                    this.ajax = false;

                    for (var i = 0; i < vm.$children.length; i++) {
                        if (vm.$children[i].$options.name == "dropbox-sync-component") {
                            vm.$children[i].start();
                        }
                    }
                },function (errorResponse) {
                    swal('There is problem please contact to system administrator!');
                }
            );
        },
        failed : function () {
            this.ajax = true;
            this.$http.get(APP_URL+'/dropbox-failed').then(
                function (successResponse) {
                    this.ajax = false;
                    for (var i = 0; i < vm.$children.length; i++) {
                        if (vm.$children[i].$options.name == "dropbox-sync-component") {
                            vm.$children[i].start();
                        }
                    }
                },function (errorResponse) {
                    swal('There is problem please contact to system administrator!');
                }
            );
        },
        pagination : function (page, namespace) {

            this.namespace = namespace;

            if (namespace == "rejected")
            {   this.page = page;
                this.rPage = page;
            } else if (namespace == "pending") {
                this.page = page;
                this.pPage = page;
            } else if (namespace == "processing")
            {
                this.page = page;
                this.prPage = page;
            } else if (namespace == "recent")
            {
                this.page = page;
                this.rePage = page;
            }

            this.start();
        },
        unprocess : function (id) {
            this.ajax = true;
            this.$http.get(APP_URL+'/dropbox-unprocess/'+id).then(
                function (successResponse) {
                    this.ajax = false;
                    for (var i = 0; i < vm.$children.length; i++) {
                        if (vm.$children[i].$options.name == "dropbox-sync-component") {
                            vm.$children[i].start();
                        }
                    }
                },function (errorResponse) {
                    swal('There is problem please contact to system administrator!');
                }
            );
        },
        delPermanent : function (id) {
            this.ajax = true;
            this.$http.get(APP_URL+'/dropbox-delete-permanent/'+id).then(
                function (successResponse) {
                    this.ajax = false;
                    for (var i = 0; i < vm.$children.length; i++) {
                        if (vm.$children[i].$options.name == "dropbox-sync-component") {
                            vm.$children[i].start();
                        }
                    }
                },function (errorResponse) {
                    swal('There is problem please contact to system administrator!');
                }
            );
        },
        retry : function (id) {
            this.ajax = true;
            this.$http.get(APP_URL+'/dropbox-retry/'+id).then(
                function (successResponse) {
                    this.ajax = false;
                    for (var i = 0; i < vm.$children.length; i++) {
                        if (vm.$children[i].$options.name == "dropbox-sync-component") {
                            vm.$children[i].start();
                        }
                    }
                },function (errorResponse) {
                    swal('There is problem please contact to system administrator!');
                }
            );
        },
        log : function () {

            for (var i = 0; i < vm.$children.length; i++) {
                if (vm.$children[i].$options.name == "queue-log-box") {
                    vm.$children[i].getLog();
                }
            }
        }
    }
})

Vue.component('queue-log-box', {
    template: '#queue-log-box',
    data : function () {
        return {
            show : false,
            startLog : ''
        }
    },
    methods : {
        getLog : function () {

            this.show = true;

            var vi = this;

            $("#queue-logs").html('<i style="position: relative; left:49%; top:200px;" class="icon-spinner11"></i>');

            this.startLog = setInterval(function () {

                vi.$http.get(APP_URL+'/dropbox-queue-logs').then(function (response) {

                    $("#queue-logs").html(response.data);
                    $("#queue-logs").animate({ scrollTop: $('#queue-logs').prop("scrollHeight")}, 1000);

                },function (response) {
                    console.log(response);
                })
            }, 1000);

            console.log(this.startLog);
        },
        closeLog: function () {
            this.show = false;
            clearInterval(this.startLog);
            $("#queue-logs").html('');
            this.startLog = '';
        }
    }
});

Vue.component('passport-clients', {
    template : '#passport-clients-html',
    data: function() {
        return {
            clients: [],

            createForm: {
                errors: [],
                name: '',
                redirect: ''
            },

            editForm: {
                errors: [],
                name: '',
                redirect: ''
            }
        };
    },
    ready: function() {
        this.getClients();

        $('#modal-create-client').on('shown.bs.modal', function() {
            $('#create-client-name').focus();
    });

        $('#modal-edit-client').on('shown.bs.modal', function() {
            $('#edit-client-name').focus();
    });
    },
    methods: {
        /**
         * Get all of the OAuth clients for the user.
         */
        getClients: function() {
            this.$http.get('/oauth/clients')
                .then(function(response) {
                this.clients = response.data;
        });
        },

        /**
         * Show the form for creating new clients.
         */
        showCreateClientForm: function() {
            $('#modal-create-client').modal('show');
        },

        /**
         * Create a new OAuth client for the user.
         */
        store: function() {
            this.persistClient(
                'post', '/oauth/clients',
                this.createForm, '#modal-create-client'
            );
        },

        /**
         * Edit the given client.
         */
        edit: function(client) {
            this.editForm.id = client.id;
            this.editForm.name = client.name;
            this.editForm.redirect = client.redirect;

            $('#modal-edit-client').modal('show');
        },

        /**
         * Update the client being edited.
         */
        update: function() {
            this.persistClient(
                'put', '/oauth/clients/' + this.editForm.id,
                this.editForm, '#modal-edit-client'
            );
        },

        /**
         * Persist the client to storage using the given form.
         */
        persistClient: function(method, uri, form, modal) {
            form.errors = [];

            this.$http[method](uri, form)
                .then(function(response) {
                this.getClients();

            form.name = '';
            form.redirect = '';
            form.errors = [];

            $(modal).modal('hide');
        })
        .catch(function(response) {
                if (typeof response.data === 'object') {
                form.errors = _.flatten(_.toArray(response.data));
            } else {
                form.errors = ['Something went wrong. Please try again.'];
            }
        });
        },

        /**
         * Destroy the given client.
         */
        destroy: function(client) {
            this.$http.delete('/oauth/clients/' + client.id)
                .then(function(response) {
                this.getClients();
        });
        }
    }
});

Vue.component('passport-authorized-clients', {
        template: '#passport-authorized-clients-html',
        data: function () {

            return {
                tokens: []
            };
        },
        ready: function() {
            this.getTokens();
        },
        methods: {
            getTokens : function() {
                this.$http.get('/oauth/tokens')
                    .then(function(response){
                    this.tokens = response.data;
                });
            },

            /**
             * Revoke the given token.
             */
            revoke: function(token) {
                this.$http.delete('/oauth/tokens/' + token.id)
                    .then(function(response){
                    this.getTokens();
                });
            }
        }
});

Vue.component('passport-personal-access-tokens', {
        template : '#passport-personal-access-tokens-html',
        data: function() {
            return {
                accessToken: null,

                tokens: [],
                scopes: [],

                form: {
                    name: '',
                    scopes: [],
                    errors: []
                }
            };
        },
        ready: function() {
            this.getTokens();
            this.getScopes();

            $('#modal-create-token').on('shown.bs.modal', function() {
                $('#create-token-name').focus();
        });
        },
        methods: {
            getTokens: function() {
                this.$http.get('/oauth/personal-access-tokens')
                    .then(function (response) {
                    this.tokens = response.data;
            });
            },

            /**
             * Get all of the available scopes.
             */
            getScopes: function() {
                this.$http.get('/oauth/scopes')
                    .then(function (response) {
                    this.scopes = response.data;
            });
            },

            /**
             * Show the form for creating new tokens.
             */
            showCreateTokenForm: function() {
                $('#modal-create-token').modal('show');
            },

            /**
             * Create a new personal access token.
             */
            store:function() {
                this.accessToken = null;

                this.form.errors = [];

                this.$http.post('/oauth/personal-access-tokens', this.form)
                    .then(function () {
                    this.form.name = '';
                this.form.scopes = [];
                this.form.errors = [];

                this.tokens.push(response.data.token);

                this.showAccessToken(response.data.accessToken);
            })
            .catch(function (response) {
                    if (typeof response.data === 'object') {
                    this.form.errors = _.flatten(_.toArray(response.data));
                } else {
                    this.form.errors = ['Something went wrong. Please try again.'];
                }
            });
            },

            /**
             * Toggle the given scope in the list of assigned scopes.
             */
            toggleScope:function(scope) {
                if (this.scopeIsAssigned(scope)) {
                    this.form.scopes = _.reject(this.form.scopes, function(s){ s == scope});
                } else {
                    this.form.scopes.push(scope);
                }
            },

            /**
             * Determine if the given scope has been assigned to the token.
             */
            scopeIsAssigned:function(scope) {
                return _.indexOf(this.form.scopes, scope) >= 0;
            },

            /**
             * Show the given access token to the user.
             */
            showAccessToken:function(accessToken) {
                $('#modal-create-token').modal('hide');

                this.accessToken = accessToken;

                $('#modal-access-token').modal('show');
            },

            /**
             * Revoke the given token.
             */
            revoke:function(token) {
                this.$http.delete('/oauth/personal-access-tokens/' + token.id)
                    .then(function () {
                    this.getTokens();
            });
            }
        }
});

Vue.component('disk-space', {
  template : '#disk-space',
  data : function(){
    return {}
  },
  ready : function(){

  }
})
// start app
var vm = new Vue({
    el: '#app'
})

sparkline("#server-load", "area", 30, 50, "basis", 750, 2000, "rgba(255,255,255,0.5)");

// Chart setup
function sparkline(element, chartType, qty, height, interpolation, duration, interval, color) {


    // Basic setup
    // ------------------------------

    // Define main variables
    var d3Container = d3.select(element),
        margin = {top: 0, right: 0, bottom: 0, left: 0},
        width = d3Container.node().getBoundingClientRect().width - margin.left - margin.right,
        height = height - margin.top - margin.bottom;


    // Generate random data (for demo only)
    var data = [];
    for (var i=0; i < qty; i++) {
        data.push(Math.floor(Math.random() * qty) + 5)
    }



    // Construct scales
    // ------------------------------

    // Horizontal
    var x = d3.scale.linear().range([0, width]);

    // Vertical
    var y = d3.scale.linear().range([height - 5, 5]);



    // Set input domains
    // ------------------------------

    // Horizontal
    x.domain([1, qty - 3])

    // Vertical
    y.domain([0, qty])



    // Construct chart layout
    // ------------------------------

    // Line
    var line = d3.svg.line()
        .interpolate(interpolation)
        .x(function(d, i) { return x(i); })
        .y(function(d, i) { return y(d); });

    // Area
    var area = d3.svg.area()
        .interpolate(interpolation)
        .x(function(d,i) {
            return x(i);
        })
        .y0(height)
        .y1(function(d) {
            return y(d);
        });



    // Create SVG
    // ------------------------------

    // Container
    var container = d3Container.append('svg');

    // SVG element
    var svg = container
        .attr('width', width + margin.left + margin.right)
        .attr('height', height + margin.top + margin.bottom)
        .append("g")
        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");



    // Add mask for animation
    // ------------------------------

    // Add clip path
    var clip = svg.append("defs")
        .append("clipPath")
        .attr('id', function(d, i) { return "load-clip-" + element.substring(1) })

    // Add clip shape
    var clips = clip.append("rect")
        .attr('class', 'load-clip')
        .attr("width", 0)
        .attr("height", height);

    // Animate mask
    clips
        .transition()
        .duration(1000)
        .ease('linear')
        .attr("width", width);



    //
    // Append chart elements
    //

    // Main path
    var path = svg.append("g")
        .attr("clip-path", function(d, i) { return "url(#load-clip-" + element.substring(1) + ")"})
        .append("path")
        .datum(data)
        .attr("transform", "translate(" + x(0) + ",0)");

    // Add path based on chart type
    if(chartType == "area") {
        path.attr("d", area).attr('class', 'd3-area').style("fill", color); // area
    }
    else {
        path.attr("d", line).attr("class", "d3-line d3-line-medium").style('stroke', color); // line
    }

    // Animate path
    path
        .style('opacity', 0)
        .transition()
        .duration(750)
        .style('opacity', 1);



    // Set update interval. For demo only
    // ------------------------------

    setInterval(function() {

        // push a new data point onto the back
        data.push(Math.floor(Math.random() * qty) + 5);

        // pop the old data point off the front
        data.shift();

        update();

    }, interval);



    // Update random data. For demo only
    // ------------------------------

    function update() {

        // Redraw the path and slide it to the left
        path
            .attr("transform", null)
            .transition()
            .duration(duration)
            .ease("linear")
            .attr("transform", "translate(" + x(0) + ",0)");

        // Update path type
        if(chartType == "area") {
            path.attr("d", area).attr('class', 'd3-area').style("fill", color)
        }
        else {
            path.attr("d", line).attr("class", "d3-line d3-line-medium").style('stroke', color);
        }
    }



    // Resize chart
    // ------------------------------

    // Call function on window resize
    $(window).on('resize', resizeSparklines);

    // Call function on sidebar width change
    $('.sidebar-control').on('click', resizeSparklines);

    // Resize function
    //
    // Since D3 doesn't support SVG resize by default,
    // we need to manually specify parts of the graph that need to
    // be updated on window resize
    function resizeSparklines() {

        // Layout variables
        width = d3Container.node().getBoundingClientRect().width - margin.left - margin.right;


        // Layout
        // -------------------------

        // Main svg width
        container.attr("width", width + margin.left + margin.right);

        // Width of appended group
        svg.attr("width", width + margin.left + margin.right);

        // Horizontal range
        x.range([0, width]);


        // Chart elements
        // -------------------------

        // Clip mask
        clips.attr("width", width);

        // Line
        svg.select(".d3-line").attr("d", line);

        // Area
        svg.select(".d3-area").attr("d", area);
    }
}



// Tickets status donut chart
// ------------------------------

//Chart setup
function ticketStatusDonut(element, size, filesData) {


    // Basic setup
    // ------------------------------

    // Add data set
    var data = filesData;

    // Main variables
    var d3Container = d3.select(element),
        distance = 2, // reserve 2px space for mouseover arc moving
        radius = (size/2) - distance,
        sum = d3.sum(data, function(d) { return d.value; })



    // Tooltip
    // ------------------------------

    var tip = d3.tip()
        .attr('class', 'd3-tip')
        .offset([-10, 0])
        .direction('e')
        .html(function (d) {
            return "<ul class='list-unstyled mb-5'>" +
                "<li>" + "<div class='text-size-base mb-5 mt-5'>" + d.data.icon + d.data.status + "</div>" + "</li>" +
                "<li>" + "Total: &nbsp;" + "<span class='text-semibold pull-right'>" + d.value + "</span>" + "</li>" +
                "<li>" + "Ratio: &nbsp;" + "<span class='text-semibold pull-right'>" + (100 / (sum / d.value)).toFixed(2) + "%" + "</span>" + "</li>" +
                "</ul>";
        })



    // Create chart
    // ------------------------------

    // Add svg element
    var container = d3Container.append("svg").call(tip);

    // Add SVG group
    var svg = container
        .attr("width", size)
        .attr("height", size)
        .append("g")
        .attr("transform", "translate(" + (size / 2) + "," + (size / 2) + ")");



    // Construct chart layout
    // ------------------------------

    // Pie
    var pie = d3.layout.pie()
        .sort(null)
        .startAngle(Math.PI)
        .endAngle(3 * Math.PI)
        .value(function (d) {
            return d.value;
        });

    // Arc
    var arc = d3.svg.arc()
        .outerRadius(radius)
        .innerRadius(radius / 2);



    //
    // Append chart elements
    //

    // Group chart elements
    var arcGroup = svg.selectAll(".d3-arc")
        .data(pie(data))
        .enter()
        .append("g")
        .attr("class", "d3-arc")
        .style('stroke', '#fff')
        .style('cursor', 'pointer');

    // Append path
    var arcPath = arcGroup
        .append("path")
        .style("fill", function (d) { return d.data.color; });

    // Add tooltip
    arcPath
        .on('mouseover', function (d, i) {

            // Transition on mouseover
            d3.select(this)
                .transition()
                .duration(500)
                .ease('elastic')
                .attr('transform', function (d) {
                    d.midAngle = ((d.endAngle - d.startAngle) / 2) + d.startAngle;
                    var x = Math.sin(d.midAngle) * distance;
                    var y = -Math.cos(d.midAngle) * distance;
                    return 'translate(' + x + ',' + y + ')';
                });
        })

        .on("mousemove", function (d) {

            // Show tooltip on mousemove
            tip.show(d)
                .style("top", (d3.event.pageY - 40) + "px")
                .style("left", (d3.event.pageX + 30) + "px");
        })

        .on('mouseout', function (d, i) {

            // Mouseout transition
            d3.select(this)
                .transition()
                .duration(500)
                .ease('bounce')
                .attr('transform', 'translate(0,0)');

            // Hide tooltip
            tip.hide(d);
        });

    // Animate chart on load
    arcPath
        .transition()
        .delay(function(d, i) { return i * 500; })
        .duration(500)
        .attrTween("d", function(d) {
            var interpolate = d3.interpolate(d.startAngle,d.endAngle);
            return function(t) {
                d.endAngle = interpolate(t);
                return arc(d);
            };
        });
}

function outer_pagination(page, namespace) {
    console.log(page);
    console.log(namespace);
    for (var i = 0; i < vm.$children.length; i++) {
        if (vm.$children[i].$options.name == "dropbox-sync-component") {
            vm.$children[i].pagination(page, namespace);
        }
    }

}

$(document).ready(function () {

    $(".control-danger").uniform({
        radioClass: 'choice',
        wrapperClass: 'border-danger-600 text-danger-800'
    });

    /**
     * D3 js code below start here
     */
    // Initialize chart
    pieEntryAnimation('#d3-pie-entry-animation', 63);
    pieEntryAnimation2('#d3-pie-entry-animation2', 63);

    // Chart setup
    function pieEntryAnimation(element, radius) {


        // Basic setup
        // ------------------------------

        // Colors
        var color = d3.scale.category20();


        // Create chart
        // ------------------------------

        // Add SVG element
        var container = d3.select(element).append("svg");

        // Add SVG group
        var svg = container
            .attr("width", radius * 2)
            .attr("height", radius * 2)
            .append("g")
            .attr("transform", "translate(" + radius + "," + radius + ")");


        // Construct chart layout
        // ------------------------------

        // Arc
        var arc = d3.svg.arc()
            .outerRadius(radius)
            .innerRadius(0);

        // Pie
        var pie = d3.layout.pie()
            .sort(null)
            .value(function(d) { return d.value; });


        // Load data
        // ------------------------------


        d3.csv("/diskone.txt", function(error, data) {

            // Pull out values
            data.forEach(function(d) {
                d.value = +d.value;
            });


            //
            // Append chart elements
            //

            // Bind data
            var g = svg.selectAll(".d3-arc")
                .data(pie(data))
                .enter()
                .append("g")
                .attr("class", "d3-arc");

            // Add arc path
            g.append("path")
                .attr("d", arc)
                .style("fill", function(d) { return color(d.data.label); })
                .transition()
                .ease("bounce")
                .duration(2000)
                .attrTween("d", tweenPie);

            // Add text labels
            g.append("text")
                .attr("transform", function(d) { return "translate(" + arc.centroid(d) + ")"; })
                .attr("dy", ".35em")
                .style("opacity", 0)
                .style("fill", "#fff")
                .style("font-size", 12)
                .style("text-anchor", "middle")
                .text(function(d) { return d.data.label; })
                .transition()
                .ease("linear")
                .delay(2000)
                .duration(500)
                .style("opacity", 1)


            // Tween
            function tweenPie(b) {
                b.innerRadius = 0;
                var i = d3.interpolate({startAngle: 0, endAngle: 0}, b);
                return function(t) { return arc(i(t));
                };
            }



        });
    }

    function pieEntryAnimation2(element, radius) {


        // Basic setup
        // ------------------------------

        // Colors
        var color = d3.scale.category20();


        // Create chart
        // ------------------------------

        // Add SVG element
        var container = d3.select(element).append("svg");

        // Add SVG group
        var svg = container
            .attr("width", radius * 2)
            .attr("height", radius * 2)
            .append("g")
            .attr("transform", "translate(" + radius + "," + radius + ")");


        // Construct chart layout
        // ------------------------------

        // Arc
        var arc = d3.svg.arc()
            .outerRadius(radius)
            .innerRadius(0);

        // Pie
        var pie = d3.layout.pie()
            .sort(null)
            .value(function(d) { return d.value; });


        // Load data
        // ------------------------------


        d3.csv("/disktwo.txt", function(error, data) {

            // Pull out values
            data.forEach(function(d) {
                d.value = +d.value;
            });


            //
            // Append chart elements
            //

            // Bind data
            var g = svg.selectAll(".d3-arc")
                .data(pie(data))
                .enter()
                .append("g")
                .attr("class", "d3-arc");

            // Add arc path
            g.append("path")
                .attr("d", arc)
                .style("fill", function(d) { return color(d.data.label); })
                .transition()
                .ease("bounce")
                .duration(2000)
                .attrTween("d", tweenPie);

            // Add text labels
            g.append("text")
                .attr("transform", function(d) { return "translate(" + arc.centroid(d) + ")"; })
                .attr("dy", ".35em")
                .style("opacity", 0)
                .style("fill", "#fff")
                .style("font-size", 12)
                .style("text-anchor", "middle")
                .text(function(d) { return d.data.label; })
                .transition()
                .ease("linear")
                .delay(2000)
                .duration(500)
                .style("opacity", 1)


            // Tween
            function tweenPie(b) {
                b.innerRadius = 0;
                var i = d3.interpolate({startAngle: 0, endAngle: 0}, b);
                return function(t) { return arc(i(t));
                };
            }



        });
    }

    /**
     * D3 js code above end here
     */

});
