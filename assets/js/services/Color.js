let randomColor = require('randomcolor');

export default class Color {

  constructor(id, alpha, luminosity) {
    this.color = randomColor({
      luminosity: luminosity,
      format: 'rgba',
      alpha: alpha, // e.g. 'rgba(9, 1, 107, 0.2)',
      seed: id + 15
    });
  }
}
