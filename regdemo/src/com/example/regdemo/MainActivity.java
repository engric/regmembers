package com.example.regdemo;




import android.os.Bundle;
import android.app.Activity;
import android.content.Intent;
import android.view.Menu;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;

public class MainActivity extends Activity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        Button inayofuata=(Button)findViewById(R.id.inayofuata);
        inayofuata.setOnClickListener(new OnClickListener(){
			@Override
			public void onClick(View v) {
				EditText jina=(EditText)findViewById(R.id.jina);
				EditText mkoa=(EditText)findViewById(R.id.mkoa);
				EditText wilaya=(EditText)findViewById(R.id.wilaya);
				EditText kata=(EditText)findViewById(R.id.kata);
				EditText simu=(EditText)findViewById(R.id.simu);
				EditText kikundi=(EditText)findViewById(R.id.kikundi);
				EditText biashara=(EditText)findViewById(R.id.biashara);
				String[] value={jina.getText().toString(),mkoa.getText().toString(),wilaya.getText().toString(),kata.getText().toString(),simu.getText().toString(),kikundi.getText().toString(),biashara.getText().toString()};
				Intent intent=new Intent(MainActivity.this,NextPage.class);
		        intent.putExtra("pageone", value);
		    	   startActivity(intent);
			}
        	
        });
    }


    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.main, menu);
        return true;
    }
    
}
