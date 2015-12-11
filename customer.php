<?php
 
class customer
{
    private $custID = '';
    private $custName = '';
    private $receiverIP = '';
    private $receiverType = '';
    private $routerIP = '';
    private $routerState = 0;

    public function setCustID($newValue) 		{$this->custID = $newValue;}
	public function getCustID()					{return $this->custID;}
	public function setCustName($newValue)		{$this->custName = $newValue;}
	public function getCustName()				{return $this->custName;}
	public function setCustAddress($newValue)	{$this->custAddress = $newValue;}
	public function getCustAddress()			{return $this->custAddress;}
	public function setCustPostCode($newValue)	{$this->custPostCode = $newValue;}
	public function getCustPostCode()			{return $this->custPostCode;}
	public function setCustTel($newValue)		{$this->custTel = $newValue;}
	public function getCustTel()				{return $this->custTel;}
	public function setCustMob($newValue)		{$this->custMob = $newValue;}
	public function getCustMob()				{return $this->custMob;}
	public function setCustType($newValue)		{$this->custType = $newValue;}
	public function getCustType()				{return $this->custType;}
	public function setReceiverIP($newValue)	{$this->receiverIP = $newValue;}
	public function getReceiverIP()				{return $this->receiverIP;}
	public function setReceiverType($newValue)	{$this->receiverType = $newValue;}
	public function getReceiverType()			{return $this->receiverType;}
	public function setRouterIP($newValue)		{$this->routerIP = $newValue;}
	public function getRouterIP()				{return $this->routerIP;}
	
	public function setRouterState($newValues)	{$this->routerState = $newValue;}
	public function getRouterState()			{return $this->routerState;}

	public function printCustomerInfo()
	{
		

		return '<table>
			<tr>
				<td>Customer ID:</td>
	        	<td>'.$this->custID.'</td>
	        </tr>
	        <tr>
	        	<td>Customer Name:</td>
	        	<td>'.$this->custName.'</td>
	        </tr>
	        <tr>
	        	<td>Customer Address:</td>
	        	<td>'.$this->custAddress.'</td>
			</tr>
	        <tr>
	        
	        	<td>Customer Postcode:</td>
	        	<td>'.$this->custPostCode.'</td>
	    	</tr>
	        <tr>
	        	<td>Customer Telephone:</td>
	        	<td>'.$this->custTel.'</td>
	        </tr>
	        <tr>
	        	<td>Customer Mobile:</td>
	        	<td>'.$this->custMob.'</td>
	        </tr>
	        <tr>
	        	<td>Customer Type:</td>
	        	<td>'.$this->custType.'</td>
	        </tr>
	        <tr>
	        	<td>Receiver Type:</td>
	        	<td>'.$this->receiverType.'</td>
	    	</tr>
	        <tr>
	      		<td>Receiver Address:</td>
	        	<td><a href="http://'.$this->receiverIP.'" target="myiframe">'.$this->receiverIP.'</a></td>
	        </tr>
	        <tr>
	        	<td>Router Address:</td>
	        	<td><a href="http://'.$this->routerIP.':64080" target="myiframe">'.$this->routerIP.':64080</a></td>
	        </tr>
	    </table>';
	}
	
	public function isReceiverOnline()
	{
 		$host=$this->getReceiverIP();

		exec("ping -c 1 " . $host, $output, $result);
		if ($result == 0)
			return true;
		else
			return false;
	}
	public function isRouterOnline()
	{

	    $host=$this->getRouterIP();

		exec("ping -c 1 " . $host, $output, $result);
		if ($result == 0)
			return true;
		else
			return false;
	}	
}
?>