@extends('admin.layout')

@section('content')
  <h1>Registrations</h1>
  <table class="table">
      <caption>Open registration requests, </caption>
      <thead>
          <tr>
              <th>Fullname</th>
              <th>Personal Info</th>
              <th>Contact Info</th>
              <th>Study Info</th>
              <th>Payment Info</th>
              <th>Subbmited at</th>
              <th>Actions</th>
          </tr>
      </thead>
      <tbody>
          <tr>
              <th scope="row">Mark Redeman</th>
              <td>
                  <i class="fa fa-check-circle-o" aria-hidden="true"></i>
              </td>
              <td>
                  <i class="fa fa-check-circle-o" aria-hidden="true"></i>
              </td>
              <td>
                  <i class="fa fa-check-circle-o" aria-hidden="true"></i>
              </td>
              <td>
                  <i class="fa fa-circle-o" aria-hidden="true"></i>
              </td>
              <td>
                  Last thursday
              </td>
              <td>
                  <a type="button" class="btn btn-default" href="/admin/registration-requests/mark-redeman">
                      <i class="fa fa-search" aria-hidden="true"></i>
                      Inspect
                  </a>
              </td>
          </tr>
          <tr>
              <th scope="row">Mark Boer</th>
              <td>
                  <i class="fa fa-circle-o" aria-hidden="true"></i>
              </td>
              <td>
                  <i class="fa fa-check-circle-o" aria-hidden="true"></i>
              </td>
              <td>
                  <i class="fa fa-circle-o" aria-hidden="true"></i>
              </td>
              <td>
                  <i class="fa fa-check-circle-o" aria-hidden="true"></i>
              </td>
              <td>
                  2 weeks ago
              </td>
              <td>
                  <a type="button" class="btn btn-default" href="/admin/registration-requests/">
                      <i class="fa fa-search" aria-hidden="true"></i>
                      Inspect
                  </a>
              </td>
          </tr>
          <tr>
              <th scope="row">Mark Redeman</th>
              <td>
                  <i class="fa fa-circle-o" aria-hidden="true"></i>
              </td>
              <td>
                  <i class="fa fa-check-circle-o" aria-hidden="true"></i>
              </td>
              <td>
                  <i class="fa fa-circle-o" aria-hidden="true"></i>
              </td>
              <td>
                  <i class="fa fa-circle-o" aria-hidden="true"></i>
              </td>
              <td>
                  Yesterday
              </td>
              <td>
                  <a type="button" class="btn btn-default" href="/admin/registration-requests/">
                      <i class="fa fa-search" aria-hidden="true"></i>
                      Inspect
                  </a>
              </td>
          </tr>
          <tr>
              <th scope="row">Mark Redeman</th>
              <td>
                  <i class="fa fa-check-circle-o" aria-hidden="true"></i>
              </td>
              <td>
                  <i class="fa fa-check-circle-o" aria-hidden="true"></i>
              </td>
              <td>
                  <i class="fa fa-check-circle-o" aria-hidden="true"></i>
              </td>
              <td>
                  <i class="fa fa-check-circle-o" aria-hidden="true"></i>
              </td>
              <td>
                  Yesterday
              </td>
              <td>
                  <a type="button" class="btn btn-default" href="/admin/registration-requests/">
                      <i class="fa fa-search" aria-hidden="true"></i>
                      Inspect
                  </a>
              </td>
          </tr>
      </tbody>
  </table>
@endsection
