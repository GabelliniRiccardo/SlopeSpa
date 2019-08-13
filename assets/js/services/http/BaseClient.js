export class BaseClient {
  constructor(resourceUrl) {
    this.baseUrl = '/staff/calendar';
    this.url = this.baseUrl + resourceUrl;
  }
}
