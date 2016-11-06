<div>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>SLN</th>
            <th>Plan Name</th>
            <th>Price</th>
            <th>Trial Period</th>
            <th>Description</th>
            <th>Feature</th>
            <th>Status</th>
            <th width="20%">Action</th>
        </tr>
        </thead>
        <tbody>
            @foreach($allPlan as $plan)
                <tr>
                    <td>{{ $sln++ }}</td>
                    <td>{{ $plan->name }}</td>
                    <td>{{ $plan->amount ."". $plan->currency_symbol[$plan->currency] }}/{{ $plan->interval }}</td>
                    <td>{{ $plan->trial_period_days }}</td>
                    <td>{{ $plan->statement_descriptor }}</td>
                    <td>
                        @foreach($plan->planFeature as $feature)
                            <p>{{ $feature->feature_name }}</p>
                        @endforeach
                    </td>
                    <td>
                        <label for="" id="{{ $plan['plan_id'] }}" class="label {{ $plan['active'] ? "label-success": "label-warning" }}">{{ $plan['active'] ? "Active": "Inactive" }}</label>
                    </td>
                    <td>
                        <a href="{{ action('StripeController@editPlanFeature',$plan) }}" class="btn btn-warning btn-xs" style="display: none;">Edit</a>

                        <form action="view-plan/ajax/update" method="post" name="action" id="{{ $plan['plan_id'] }}" class="form-horizontal change_status">
                            {{ csrf_field() }}
                            <input type="hidden" name="plan" id="plan_id" value="{{ $plan['plan_id'] }}">
                            <select name="confirm_action" id="select_action" onchange="setFormActionOnChange(this)">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                                <option value="{{ $plan['plan_id'] }}">Edit</option>
                                <option value="Delete" >Delete</option>
                            </select>
                            <input type="submit" class="btn btn-info btn-sm btn-flat" id="submit-{{ $plan['plan_id'] }}" data-toggle="modal" data-target="" value="Confirm">
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>