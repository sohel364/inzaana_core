// Oop.cpp : Defines the entry point for the console application.
//

#include "stdafx.h"
#include <functional>
#include <assert.h>

using namespace std;
class Employee;

int Add(int a, int b)
{
	return a + b;
}

typedef int(*funcptr)(int, int);

typedef struct CEmployee
{
	int a;
	int(Employee::*funcFind)(int);
	int init(Employee* emp)
	{		
		auto value = (*emp.*funcFind)(10);
		return value;
	}
} emp;


class Office
{
public:
	int m_id;
};

class abstractCls
{
	void Test3()
	{}
	virtual void test1();
	//void virtual test() = 0;
};

class Employee
{	
public:
	int m_value;
	char* m_name;
	Office* office;
private:
	int m_test_friend;
	void friendMethod()
	{

	}
public:
	int FindID(int a)
	{
		return 0;
	}
public:

	Employee()
	{
		office = new Office();
		office->m_id = 10;
		std::cout << office->m_id << endl;
		std::cout << L"Constructor";		
	}
	~Employee()
	{
		std::cout << L"Destructor";
	}
	Office* GetOffice(Office& office)
	{
		return &office;
	}

	friend class ABC;
};

class ABC
{
public:	Employee emp;
private:	void init()
	{
		emp = Employee();
		emp.friendMethod();
	}
};

class ExtendEmployee
{
	Employee* emp = new Employee;
public :
	int(Employee::*findId)(int);
	int init(Employee* empParam)
	{
		findId = &Employee::FindID;		
		return (*empParam.*findId)(10);		
	}
};

int* X()
{
	int* val = new int(10);

	val = new int(25);
	return val;
}

int Add2To3(int(*funcptr)(int, int), int next)
{
	return funcptr(10, 20) + next;
}


// const value and const reference
int subs(const int* a, int* const b)
{
	return (*a + *b);
}

int main(void)
{
	abstractCls a;

	FILE* fbuffer = fopen("file.txt", "w");
	fprintf(fbuffer, "hello");
	fclose(fbuffer);
	ferror(fbuffer);

	char* ch = "a";
	cout << ch << endl;
	free(ch);
	cout << ch;
	return 0;

	int* const num = new int(5);	 // address constant, value not constant
	const int* num2 = new int(10); // copied address to another const
	//cout << *num; // prints 5

	subs(num, num); // value of num is mutable
	//subs(num2, num2); // cant accept as num2 address is immutable
	//std::cout << *b  << "-" << *a;
	// reinter_pretcast

	int* intVal = new int(10);
	uint16_t* castedintVal = reinterpret_cast<uint16_t*>(intVal);
	int* finalOutcome = reinterpret_cast<int*>(castedintVal);
	assert(*intVal == *finalOutcome);
	assert(intVal == finalOutcome);

	Employee* emp = new Employee;
	emp->m_name = "hhh";
	int* empInt = reinterpret_cast<int*>(emp);
	Employee* reinEmp = reinterpret_cast<Employee*>(empInt);

	cout << "reinterpreted " << reinEmp->m_name << "original " << emp->m_name << endl;

	assert(emp == reinEmp);


	funcptr func;
	func = &Add;


	std::cout << func(10, 20) << endl;
	ExtendEmployee* Cemployee = new ExtendEmployee;
	
	CEmployee* empl = new CEmployee;
	empl->a = 10;
	delete empl;
	empl = NULL;

	const char STACK_BEGIN = 'A'; //a lot of code 

	Employee* employee = new Employee();
	employee->m_name = "taj";
	employee->m_name = "sohel";

	cout << *X() << endl;

	auto lamda = [](int a, int b) {return a > b; };

	if (lamda(10, 20))
	{
		std::cout << "first is greater than second" << endl;
	}
	else
	{
		std::cout << "second is greater than second" << endl;
	}

    return 0;
}

