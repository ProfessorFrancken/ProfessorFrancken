(function() {
    var time, vendor, vendors, _i, _len;

    time = 0;
    vendors = ['ms', 'moz', 'webkit', 'o'];
    for (_i = 0, _len = vendors.length; _i < _len; _i++) {
        vendor = vendors[_i];
        if (!(!window.requestAnimationFrame)) {
            continue;
        }
        window.requestAnimationFrame = window[vendor + 'RequestAnimationFrame'];
        window.cancelRequestAnimationFrame = window[vendor + 'CancelRequestAnimationFrame'];
    }
    if (!window.requestAnimationFrame) {
        window.requestAnimationFrame = function(callback, element) {
            var delta, now, old;

            now = new Date().getTime();
            delta = Math.max(0, 16 - (now - old));
            setTimeout((function() {
                return callback(time + delta);
            }), delta);
            return old = now + delta;
        };
    }
    if (!window.cancelAnimationFrame) {
        return window.cancelAnimationFrame = function(id) {
            return clearTimeout(id);
        };
    }
})();

var Particle = function(x, y, vx, vy) {
    this.x = x;
    this.y = y;

    this.vx = vx;
    this.vy = vy;

    this.number = Math.floor(Math.random() * 3);
};

Particle.prototype.applyPeriodicBoundaryConditions = function (bounds) {
    this.x = (this.x + this.vx) % bounds.x;
    if (this.x < 0) {
        this.x += bounds.x
    }

    this.y = (this.y + this.vy) % bounds.y;

    if (this.y < 0) {
        this.y += bounds.y

        // this.x = sim.grid.width / 2;
        // this.y = sim.grid.height / 2;
    }
};

Particle.prototype.applyWormHoldeBoundaryCondition = function (bounds) {
    if (this.x < 0) {
        this.x = sim.grid.width / 2;
        this.y = sim.grid.height / 2;
    }

    if (this.x >= bounds.x) {
        this.x = sim.grid.width / 2;
        this.y = sim.grid.height / 2;
    }

    if (this.y < 0) {
        this.x = sim.grid.width / 2;
        this.y = sim.grid.height / 2;
    }

    if (this.y >= bounds.y) {
        this.x = sim.grid.width / 2;
        this.y = sim.grid.height / 2;
    }
};

Particle.prototype.applyBounceBackOnBoundaries = function (bounds) {
    if (this.x < 0) {
        this.vx = -this.vx;
        this.vy = this.vy;
    }

    if (this.x >= bounds.x) {
        this.vx = -this.vx;
        this.vy = this.vy;
    }

    if (this.y < 0) {
        this.vx = this.vx;
        this.vy = -this.vy;
    }

    if (this.y >= bounds.y) {
        this.vx = this.vx;
        this.vy = -this.vy;
    }
};

Particle.prototype.update = function(bounds) {

    //this.applyBounceBackOnBoundaries(bounds);

    this.x = this.x + this.vx;
    this.y = this.y + this.vy;

    this.applyWormHoldeBoundaryCondition(bounds);
};

Particle.prototype.normalizedVelocity = function() {
    v = Math.sqrt(this.vx * this.vx + this.vy * this.vy) / 3;
    return { x: this.vx / v, y: this.vy / v };
}

Particle.prototype.draw = function(ctx) {

    ctx.save();

    if (this.number === 0 ) {
        ctx.strokeStyle = ctx.fillStyle = '#458b2a';
    }
    if (this.number === 1) {
        ctx.strokeStyle = ctx.fillStyle = '#173249';
    }
    if (this.number === 2 ) {
        ctx.strokeStyle = ctx.fillStyle = '#E63C39';
    }

    var radius = 4;
    ctx.beginPath();
    ctx.arc(this.x, this.y, radius, 0, 2 * Math.PI);
    ctx.fill();
    ctx.restore();
};

var Simulation = function(amountOfParticles) {
    this.canvas = document.getElementById('mpcCanvas');
    this.context = this.canvas.getContext("2d");
    this.temperature = 50;

    this.streamSteps = 0;

    this.bounds = {
        x: 1600,
        y: 680
    };
    // n = 5 * 2* 2;
    // m = 4 * 2 * 2;
    n = 40;
    m = 22;

    n = 20;
    m = 14;
    this.createGrid(n, m);

    this.shouldDrawGrid = true;

    this.alpha = Math.PI * 0.25;

    this.createParticles(amountOfParticles);
    this.draw();
};

Simulation.prototype.createGrid = function(n, m) {
    this.grid = new Grid(n, m, this.bounds.x, this.bounds.y, 0, 0);
};

Simulation.prototype.draw = function() {
    this.drawGrid();
    for (var j = 0; j < this.particles.length; j++) {
        var particle = this.particles[j];
        particle.draw(this.context);
    };
};

Simulation.prototype.drawGrid = function() {
    if (! this.shouldDrawGrid) {
        return;
    }

    this.grid.draw(this.context);
};

Simulation.prototype.update = function() {
    this.canvas.width = this.canvas.width;
    if (this.streamSteps != 0) {
        this.grid.emptyCells();
        this.stream();
        this.draw();

    } else if (this.playsteps != 0) {
        this.collide(this.alpha);
        this.draw();

        this.grid.reset();
        this.playsteps--;
        // We want another collision, but that means we first need to stream
        if (this.playsteps != 0) {
            this.streamSteps = 25;
        }
    }

    if (this.playsteps != 0 || this.streamSteps != 0) {
        window.requestAnimationFrame(this.update.bind(this));
    }
};

Simulation.prototype.play = function(steps) {
    this.playsteps = steps;
    this.streamSteps = 5;
    this.update();
};

Simulation.prototype.stream = function() {
    for (var j = 0; j < this.particles.length; j++) {
        var particle = this.particles[j];
        particle.update(this.bounds);

        this.grid.findCell(particle.x, particle.y).addParticle(particle);
    };

    this.streamSteps--;
};

Simulation.prototype.collide = function(alpha) {
    this.grid.applyCollisions(alpha);
};

Simulation.prototype.createParticles = function(n, space) {
    this.particles = [];
    var magnitude = 10;
    var tvx = 0;
    var tvy = 0;
    for (var i = 0; i < n; i++) {
        x = Math.random() * this.bounds.x;
        y = Math.random() * this.bounds.y;
        vx = Math.random() * (magnitude * 2) - magnitude;
        vy = Math.random() * (magnitude * 2) - magnitude;

        tvx += vx;
        tvy += vy;

        this.particles[i] = new Particle(x, y, vx, vy);
    };
    avx = tvx / n;
    avy = tvy / n;
    // Normalize velocities
    for (var i = 0; i < n; i++) {
        this.particles[i].vx -= avx;
        this.particles[i].vy -= avy;
    }

    // Setup termperature
    var temp = 0;
    for (var i = 0; i < n; i++) {
        temp += Math.pow(this.particles[i].vx, 2) + Math.pow(this.particles[i].vy, 2);
    }
    temp = temp / (2 * n);
    temp = Math.sqrt(this.temperature / temp);
    tempx = temp * this.grid.n / (this.grid.width);
    tempy = temp * this.grid.m / (this.grid.height);
    temp = Math.sqrt(tempx * tempx + tempy * tempy) * 10;
    for (var i = 0; i < n; i++) {
        this.particles[i].vx *= temp;
        this.particles[i].vy *= temp;
        // this.particles[i].vx += 5;
    }

    /* this.particles[0].follow = true;*/
};

var Grid = function(n, m, width, height, shiftX, shiftY) {
    this.cells = [];

    this.n = n;
    this.m = m;
    this.width = width;
    this.height = height;

    // Shift for Galilean invariance
    this.shiftX = shiftX;
    this.shiftY = shiftY;

    var cellWidth = this.width / n;
    var cellHeight = this.height / m;

    for (var i = 0; i < this.n + 1; i++) {
        this.cells[i] = [];

        for (var j = 0; j < this.m + 1; j++) {
            this.cells[i][j] = new GridCell(i * cellWidth, j * cellHeight, cellWidth, cellHeight);

            // if (i == Math.floor(n /2)) {
            //     this.cells[i][j].wall = true;
            // }
            // if (i == Math.floor(n /2) + 1) {
            //     this.cells[i][j].wall = true;
            // }
            // if (i == Math.floor(n /2) - 1) {
            //     this.cells[i][j].wall = true;
            // }
        };
    };
};

Grid.prototype.findCell = function(x, y) {
    x = x + this.shiftX;
    y = y + this.shiftY;

    x = Math.floor(x * this.n / this.width)
    y = Math.floor(y * this.m / this.height)

    return this.cells[x][y];
};

Grid.prototype.reset = function() {
    this.emptyCells();

    // this.shiftX = Math.random() * (this.width / this.n);
    // this.shiftY = Math.random() * (this.height / this.m);
}

Grid.prototype.emptyCells = function() {
    for (var i = 0; i < this.n + 1; i++) {
        for (var j = 0; j < this.m + 1; j++) {
            this.cells[i][j].reset();
        };
    };
}

Grid.prototype.applyCollisions = function(alpha) {
    for (var i = 0; i < this.n + 1; i++) {
        for (var j = 0; j < this.m + 1; j++) {
            this.cells[i][j].applyCollisions(alpha);
        };
    };
}

Grid.prototype.draw = function(context) {
    cellWidth = this.width / this.n;
    cellHeight = this.height / this.m;

    for (var i = 0; i < this.n + 1; i++) {
        for (var j = 0; j < this.m + 1; j++) {
            cell = this.cells[i][j];

            var follow = false;
            // for (var k = cell.particles.length - 1; k >= 0; k--) {
            //     if (cell.particles[k].follow) { follow = true; break; }
            // };

            context.beginPath();
            context.rect(cell.x - this.shiftX, cell.y - this.shiftY, cellWidth, cellHeight);
            context.lineWidth = 1;
            if (cell.wall)
            {
                context.fillStyle = '#332';
                context.fill();
            }
            if (follow) {
                context.fillStyle = 'orange';
                context.fill();
            }
            context.strokeStyle = '#eee';
            context.stroke();

        };
    };
};

GridCell = function(x, y, width, height) {
    this.x = x;
    this.y = y;
    this.width = width;
    this.height = height;
    this.reset();
    this.wall = false;
};

GridCell.prototype.reset = function() {
    this.particles = [];
    this.tvx = 0;
    this.tvy = 0;
};

GridCell.prototype.addParticle = function(particle) {
    this.particles[this.particles.length] = particle;
    this.tvx += particle.vx;
    this.tvy += particle.vy;
};

GridCell.prototype.averageVelocity = function() {
    n = this.particles.length;
    if (n > 0) {
        return {
            x: this.tvx / n,
            y: this.tvy / n
        };
    }
    return { x: 0, y: 0 };
};

GridCell.prototype.applyCollisions = function(alpha) {
    if (this.particles.length == 0) {
        return;
    }

    if (this.wall === true) {
        mx = this.x + this.width / 2;
        my = this.y + this.height / 2;
        for (var i = this.particles.length - 1; i >= 0; i--) {
            vx = this.particles[i].vx;
            vy = this.particles[i].vy;

            dx = mx - vx;
            dy = my - vy;

            if (dx > 0) {
                this.particles[i].vx *= -1;
            }
            if (dy > 0) {
                this.particles[i].vy *= -1;
            }
        };
    } else {
        v = this.averageVelocity();
        avx = v.x;
        avy = v.y;

        if (Math.random() < 0.5) {
            alpha = - alpha;
        }

        for (var i = this.particles.length - 1; i >= 0; i--) {
            particle = this.particles[i];
            vx = particle.vx;
            vy = particle.vy;
            particle.vx = avx + Math.cos(alpha) * (vx - avx) + Math.sin(alpha) * (vy - avy);
            particle.vy = avy - Math.sin(alpha) * (vy - avy) + Math.cos(alpha) * (vx - avx);

            if (this.well === true && particle.number == this.number) {
                dx = this.x - particle.x + this.width / 2;
                dy = this.y - particle.y + this.height / 2;

                particle.vx *= 0.1;// * Math.abs(dx) / this.width;
                particle.vy *= 0.1;// * Math.abs(dy) / this.height;
            }
        };
    }
};

Simulation.prototype.placeParticlesIn404Pattern = function () {

    // 404
    /*
      /    |  | |---| |  |
      /    |__| |   | |__|
      /       | |   |    |
      /       | |---|    |
    */

    var start_x = 4; //14;
    var start_y = 4; //8;

    var cells = [
       [start_x, start_y],
       [start_x + 2, start_y],

       [start_x + 4, start_y],
       [start_x + 5, start_y],
       [start_x + 6, start_y],
       [start_x + 7, start_y],

       [start_x + 9, start_y],
       [start_x + 9 + 2, start_y],

       [start_x, start_y + 1],
       [start_x + 2, start_y + 1],

       [start_x + 4, start_y + 1],
       [start_x + 7, start_y + 1],

       [start_x + 9, start_y + 1],
       [start_x + 9 + 2, start_y + 1],

       [start_x, start_y + 2],
       [start_x + 1, start_y + 2],
       [start_x + 2, start_y + 2],

       [start_x + 4, start_y + 2],
       [start_x + 7, start_y + 2],

       [start_x + 9, start_y + 2],
       [start_x + 9 + 1, start_y + 2],
       [start_x + 9 + 2, start_y + 2],

       [start_x + 2, start_y + 3],

       [start_x + 4, start_y + 3],
       [start_x + 7, start_y + 3],

       [start_x + 9 + 2, start_y + 3],

       [start_x + 2, start_y + 4],

       [start_x + 4, start_y + 4],
       [start_x + 7, start_y + 4],

       [start_x + 9 + 2, start_y + 4],

       [start_x + 2, start_y + 5],

       [start_x + 4, start_y + 5],
       [start_x + 5, start_y + 5],
       [start_x + 6, start_y + 5],
       [start_x + 7, start_y + 5],

       [start_x + 9 + 2, start_y + 5],
    ];

    var first_four = [
        [start_x, start_y],
        [start_x + 2, start_y],

        [start_x, start_y + 1],
        [start_x + 2, start_y + 1],

        [start_x, start_y + 2],
        [start_x + 1, start_y + 2],
        [start_x + 2, start_y + 2],

        [start_x + 2, start_y + 3],

        [start_x + 2, start_y + 4],

        [start_x + 2, start_y + 5],
    ];

    var zero = [
       [start_x + 4, start_y],
       [start_x + 5, start_y],
       [start_x + 6, start_y],
       [start_x + 7, start_y],

       [start_x + 4, start_y + 1],
       [start_x + 7, start_y + 1],

       [start_x + 4, start_y + 2],
       [start_x + 7, start_y + 2],

       [start_x + 4, start_y + 3],
       [start_x + 7, start_y + 3],

       [start_x + 4, start_y + 4],
       [start_x + 7, start_y + 4],

       [start_x + 4, start_y + 5],
       [start_x + 5, start_y + 5],
       [start_x + 6, start_y + 5],
       [start_x + 7, start_y + 5],
    ];

    var second_four = [
       [start_x + 9, start_y],
       [start_x + 9 + 2, start_y],

       [start_x + 9, start_y + 1],
       [start_x + 9 + 2, start_y + 1],

       [start_x + 9, start_y + 2],
       [start_x + 9 + 1, start_y + 2],
       [start_x + 9 + 2, start_y + 2],

       [start_x + 9 + 2, start_y + 3],

       [start_x + 9 + 2, start_y + 4],

       [start_x + 9 + 2, start_y + 5],
    ];

    var randomElement = function(array) {
        return array[Math.floor(Math.random() * array.length)];
    };

    for (var g = 0; g < cells.length; g++) {
        this.grid.cells[cells[g][0]][cells[g][1]].well = true;
    }

    for (var g = 0; g < first_four.length; g++) {
        this.grid.cells[first_four[g][0]][first_four[g][1]].number = 1;
    }

    for (var g = 0; g < zero.length; g++) {
        this.grid.cells[zero[g][0]][zero[g][1]].number = 2;
    }

    for (var g = 0; g < second_four.length; g++) {
        this.grid.cells[second_four[g][0]][second_four[g][1]].number = 0;
    }

    return;
    var cellWidth = this.grid.width / this.grid.n;
    var cellHeight = this.grid.height / this.grid.m;

    for (var j = 0; j < this.particles.length; j++) {
        var particle = this.particles[j];

        var aCellIndex = randomElement(cells);

        var x = (Math.random() + aCellIndex[0]) * cellWidth;
        var y = (Math.random() * aCellIndex[1]) * cellHeight;

        particle.x = (Math.random()/2 + aCellIndex[0]) * cellWidth;
        particle.y = (Math.random()/2 + aCellIndex[1]) * cellHeight;
    }

    return;
};

// Button thing
var step = 0;
var sim;
function next() {
    var stop = document.getElementsByClassName('btn-stop');
    var play = document.getElementsByClassName('btn-play');
    switch(step) {
    case 0:
        sim = new Simulation(2500);
        sim.placeParticlesIn404Pattern();
        // sim.particles = sim.particles.splice(0, 1);
        // sim.particles[0].vx = 0.5;
        // sim.particles[0].vy = 0.5;
        sim.play(-1);
        break;
    }
    step++;
}
next();

function stop() {
    var stop = document.getElementsByClassName('btn-stop');
    var play = document.getElementsByClassName('btn-play');
    play[0].innerHTML = 'Start simulation';
}
