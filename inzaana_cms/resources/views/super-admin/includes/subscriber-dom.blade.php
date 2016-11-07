<table class="table table-bordered">
    <thead>
    <tr>
        <th>SLN</th>
        <th data-sort="name" data-order="{{ $order }}" id="click_by_sort">
            <a href="#">Subscriber
                @if($order == 'ASC' && $sort == 'name')
                    <i class="fa fa-caret-up" aria-hidden="true"></i>
                @elseif($order == 'DESC' && $sort == 'name')
                    <i class="fa fa-caret-down" aria-hidden="true"></i>
                @endif
            </a>
        </th>
        <th data-sort="email" data-order="{{ $order }}" id="click_by_sort">
            <a href="#">E-mail
                @if($order == 'ASC' && $sort == 'email')
                    <i class="fa fa-caret-up" aria-hidden="true"></i>
                @elseif($order == 'DESC' && $sort == 'email')
                    <i class="fa fa-caret-down" aria-hidden="true"></i>
                @endif
            </a>
        </th>
        <th>
            Contact
        </th>
        <th>
            Address
        </th>
        <th data-sort="plan" data-order="{{ $order }}" id="click_by_sort">
            <a href="#">Plan
                @if($order == 'ASC' && $sort == 'plan')
                    <i class="fa fa-caret-up" aria-hidden="true"></i>
                @elseif($order == 'DESC' && $sort == 'plan')
                    <i class="fa fa-caret-down" aria-hidden="true"></i>
                @endif
            </a>
        </th>
        <th>
            Store
        </th>
        <th>
            Status
        </th>
        <th>
            Trial
        </th>
        <th>
            Action
        </th>
    </tr>
    </thead>
    <tbody>

    @foreach($subscribers as $subscriber)
        <tr>
            <td> {{ $sln++ }} </td>
            <td>{{ $subscriber->subscriber_name }}</td>
            <td>{{ $subscriber->email }}</td>
            <td>0173043343</td>
            <td>33/A eskaton garden</td>
            <td>{{ $subscriber->plan_name }} ({{ $subscriber->amount }}/{{ $subscriber->interval }})</td>
            <td>
                @foreach($subscriber->store_name as $store)
                    <li style="list-style: none;padding: 0;margin: 0;">
                        @if($store[1]=='APPROVED')
                            <span class="text-green"><i class="fa fa-check" aria-hidden="true"></i> </span> {{ $store[0] }}
                        @else
                            <span class="text-red"><i class="fa fa-times" aria-hidden="true"></i> </span>{{ $store[0] }}
                        @endif
                    </li>
                @endforeach

            </td>
            <td><span class="label label-success">Active</span></td>
            <td>{{ $subscriber->trial }}</td>
            <td>
                <!--<button class="btn btn-primary btn-xs" data-id="{{ $subscriber->stripe_id }}" id="user_details">Details</button>-->

                @include('includes.approval-buttons', [ 'status' => 'ON_APPROVAL', 'route' => [ 'namespace' => 'admin::', 'type' => 'subscribers' ], 'id' => $subscriber->id])

            </td>
        </tr>
    @endforeach
    </tbody>
</table>