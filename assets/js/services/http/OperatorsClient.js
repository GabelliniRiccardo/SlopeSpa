import {BaseClient} from "./BaseClient";

class OperatorsClient extends BaseClient {

  constructor() {
    super('/operators/');
  }

  getOperators() {
    let operators = [];
    $.ajax({
      type: 'GET',
      url: this.url
    }).done(function (response) {
      response.forEach(function (op) {
        operators.push(
          {
            id: op.id,
            title: op.firstName + " " + op.lastName
          }
        )
      });
    }).fail(function (response) {
      console.error('Ajax request for operators done');
    });

    return operators;
  }

}

export const operatorsClient = new OperatorsClient();
