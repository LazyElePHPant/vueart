<html>
    <head>
        <style type="text/css">
            #svg {
                width:100%;
                height:100%;
                position:fixed;
                top:0;
                left:0;
                bottom:0;
                right:0;
            }
        </style>
    </head>
    <body>
        <div id="app">
            <svg id="svg" xmlns="http://www.w3.org/2000/svg">
                <path v-for="path in paths"
                      :d="path.d"
                      :stroke="path.stroke"
                      :stroke-width="path.strokeWidth"
                      :fill="path.fill"
                      :opacity="path.opacity"></path>
            </svg>
        </div>
    </body>
</html>

<script src="https://cdn.jsdelivr.net/npm/vue@2.6.10/dist/vue.js"></script>
<script>
	let app = new Vue({
        el: '#app',

        data: {
            paths: [],
            reverse: false,
            m: ''
        },

        methods: {
			color: function () {
				let letters = '0123456789ABCDEF';
                let color = '#';

                for (let i = 0; i < 6; i++) {
                    color += letters[Math.floor(Math.random() * 16)];
                }
                return color;
			},

            coordinates: function () {
                let Q = '';
                let degrees = 360;

                for (let i = 0; i < 4; i++) {
                    Q += " " + (Math.floor((Math.random() * (degrees*2+1)) - degrees));
                }
                return Q;
            },

            moveToX: function () {
                return Math.ceil(window.innerWidth / 2);
            },

            moveToY: function () {
                return Math.ceil(window.innerHeight / 2);
            },

            init: function () {
                if (this.reverse) {
                    this.paths.pop();
                    if (this.paths.length == 1) {
                        this.reverse = false;
                    }
                    return;
                }

                let rect = document.getElementById('svg').getBoundingClientRect();


                let path = {
                    d: ('d','M ' + this.m + 'q' + this.coordinates().toString()),
                    stroke: this.color(),
                    strokeWidth: 2,
                    strokeLineJoin: 'round',
                    fill: 'none',
                    opacity: 1
                };

                this.paths.push(path);

                if (this.paths.length >= 300) {
                    this.reverse = true;
                }
            }
		},

        mounted: function () {
            this.m = this.moveToX().toString() + " " + this.moveToY().toString();
            setInterval(e => this.init(), 5);
        }
	});
</script>
