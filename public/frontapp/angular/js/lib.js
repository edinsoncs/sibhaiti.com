function TodoCtrl($scope) {
	$scope.todos = [
	{
		text:'learn angular', 
		done:false
	},

	{
		text:'build an angular app', 
		done:false
	}];
     
	$scope.addTodo = function() {
		$scope.todos.push({
			text:$scope.todoText, 
			done:false
		});
		$scope.todoText = '';
	};
     
	$scope.remaining = function() {
		var count = 0;
		angular.forEach($scope.todos, function(todo) {
			count += todo.done ? 0 : 1;
		});
		return count;
	};
	$scope.getTotalTodos = function() {		
		return $scope.todos.length;
	};
     
	$scope.archive = function() {
		var oldTodos = $scope.todos;
		$scope.todos = [];
		angular.forEach(oldTodos, function(todo) {
			if (!todo.done) $scope.todos.push(todo);
		});
	};
}

function Table($scope) {
	$scope.rows = [
	{
		name:'aaa', 
		age:22
	},

	{
		name:'bbb', 
		age:23
	}];
	
	$scope.addRow = function() {
		$scope.rows.push({
			name:$scope.rowName, 
			age:$scope.rowAge
		});
		$scope.rowName = '';
		$scope.rowAge = '';
	};
	
	$scope.remove = function() {
		var rows = $scope.rows;
		$scope.rows = [];
		angular.forEach(oldTodos, function(todo) {
			if (!todo.done) $scope.todos.push(todo);
		});
	};
}
