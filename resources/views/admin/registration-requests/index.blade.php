@extends('admin.layout')

@section('content')
  <h1 class="section-header">
    Registrations
  </h1>

  <table class="table table-hover">
      <caption>Open registration requests, you can either inspect a request (and possibly complete the registration), or mark it as spam in which case the request will be deleted.</caption>
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
          @foreach ($requests as $request)
          <tr class="{{ $request->complete() ? 'success' : '' }}" >
              <th scope="row">{{ $request->requestee() }}</th>
              <td>
                  <i class="fa {{ $request->hasPersonalInfo() ? 'fa-check-circle-o' : 'fa-circle-o' }}" aria-hidden="true"></i>
              </td>
              <td>
                  <i class="fa {{ $request->hasContactInfo() ? 'fa-check-circle-o' : 'fa-circle-o' }}" aria-hidden="true"></i>
              </td>
              <td>
                  <i class="fa {{ $request->hasStudyInfo() ? 'fa-check-circle-o' : 'fa-circle-o' }}" aria-hidden="true"></i>
              </td>
              <td>
                  <i class="fa {{ $request->hasPaymentInfo() ? 'fa-check-circle-o' : 'fa-circle-o' }}" aria-hidden="true"></i>
              </td>
              <td>
                  Last thursday
              </td>
              <td>
                  <a class="btn btn-outline-success" href="/admin/registration-requests/{{ $request->id() }}">
                      <i class="fa fa-search" aria-hidden="true"></i>
                      Inspect
                  </a>
                  <button class="btn-link text-danger btn-xs">
                      <i class="fa fa-trash-o" aria-hidden="true"></i>
                      Mark as spam
                  </button>
              </td>
          </tr>
          @endforeach
      </tbody>
  </table>
@endsection
