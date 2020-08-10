@extends('layouts.app')

@section('title')
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1>
        Leave Request
      </h1>
    </div>
  </div>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
        <!-- Widget: user widget style 2 -->
        <div class="card card-widget widget-user-2">
          <!-- Add the bg color to the header using any of the bg-* classes -->
          <div class="widget-user-header bg-danger">
            <div class="widget-user-image">
              <img class="profile-user-img img-fluid img-circle" src="{{ $leave->user->image ? asset('dist/img/user/'.$leave->user->image) : asset('dist/img/avatar5.png') }}" alt="User profile picture">
            </div>
            <!-- /.widget-user-image -->
            <h3 class="widget-user-username">{{ $leave->user->name }} ({{ $leave->user->username }})</h3>
            <h5 class="widget-user-desc">{{ $leave->user->job }} {{ $leave->department->department_name }}</h5>
          </div>
          <div class="card-footer p-0">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link">
                  Status <span class="float-right">
                    @if ($leave->approve == 0)
                      Pending
                    @elseif ($leave->approve == 1)
                      Approved
                    @else
                      Canceled
                    @endif
                  </span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link">
                  @if ($leave->approve == 0)
                      Pending
                    @elseif ($leave->approve == 1)
                      Approved by <span class="float-right">{{ $leave->approvedBy->job }} {{ $leave->department->department_name }}</span>
                    @else
                      Canceled by <span class="float-right">{{ $leave->approvedBy->job }} {{ $leave->department->department_name }}</span>
                    @endif
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link">
                    Izin <span class="float-right">{{ $leave->type == '0' ? 'Dinas' : 'Pribadi' }}</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link">
                  Tanggal <span class="float-right">{{ $leave->date }}</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link">
                  Jam <span class="float-right">{{ $leave->start }} - {{ $leave->end }}</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link">
                  Tujuan <span class="float-right">{{ $leave->destination }}</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link">
                  Keterangan <span class="float-right"><h3>{{ $leave->detail }}</h3></span>
                </a>
              </li>
            </ul>
          </div>
        </div>
        <!-- /.widget-user -->
      </div>
  </div>
@endsection
